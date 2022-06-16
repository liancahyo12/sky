<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\mobil;
use App\Models\jenis_paket;
use App\Models\biaya_mobil;
use App\Models\pelanggan;
use App\Models\wilayah;
use App\Models\driver;
use App\Models\pembayaran;
use App\Models\jenis_identitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Section;
use NcJoes\OfficeConverter\OfficeConverter;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::booking.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::booking.create', [
            'mobil' => mobil::where([['status', '=', 1], ['sedia_status', '=', 1]])->get(['id', DB::raw('concat(merek, " ", tipe, " ", plat) as mobil')])->all(),
            'biaya_mobil' => biaya_mobil::leftJoin('jenis_pakets', 'jenis_pakets.id', 'biaya_mobils.jenis_paket_id')->where([['biaya_mobils.status' , '=', 1],['jenis_pakets.status', '=', 1]])->get(['biaya_mobils.id', 'mobil_id', 'biaya_investor', 'biaya_danlap', 'biaya_driver', 'jenis_paket'])->all(),
            'wilayah' => wilayah::where(DB::raw('CHAR_LENGTH(kode)'), 2)->get()->all(),
            'driver' => driver::where([['status', '=', 1], ['sedia_status', '=', 1]])->get()->all(),
            'jenis_identitas' => jenis_identitas::where('status', 1)->get()->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'pelanggan_radio'  => 'required',
                'nama'  => 'required',
                'jenis_identitas'  => 'required',
                'no_identitas'  => 'required',
                'alamat' => 'required',
                'tgl_sewa' => 'required',
                'wilayah' => 'required',
                'driver' => 'required',
                'mobil' => 'required',
                'jenis_paket' => 'required',
                'biaya_investor' => 'required',
                'biaya_danlap' => 'required',
                'total_biaya' => 'required',
                'biaya_adm' => 'required',
            ]);

        // driver req
        if ($request->driver != 'xx') {
            $this->validate($request, [
                'biaya_driver' => 'required',
            ]);
        }

        //data booking
        $nama_pelanggan;
        $alamat;
        $driver;
        $bbmtol= '';
        $booking['mobil_id'] = $request->mobil;
        $booking['jenis_paket_id'] = biaya_mobil::where('id', $request->jenis_paket)->value('jenis_paket_id');
        $booking['biaya_mobil_id'] = $request->jenis_paket;
        if ($request->driver!='xx') {
            $booking['driver_id'] = $request->driver;
            $driver = 'Driver';
        }else {
            $driver = '*Tidak termasuk Biaya Driver';
        }

        if ($request->biaya_bbmtol>0) {
            $bbmtol = 'BBM dan Tol';
        }else {
            $bbmtol = '*Tidak termasuk Biaya BBM dan Tol';
        }
        $booking['awal_sewa'] = $request->input('tgl_sewa.start');
        $booking['akhir_sewa'] = $request->input('tgl_sewa.end');
        $booking['wilayah_id'] = $request->wilayah;
        $booking['biaya_investor'] = $request->biaya_investor;
        $booking['biaya_danlap'] = $request->biaya_danlap;
        $booking['biaya_bbmtol'] = $request->biaya_bbmtol;
        $booking['biaya_driver'] = $request->biaya_driver;

        $hari = Carbon::parse($request->input('tgl_sewa.start'))->diffInDays(Carbon::parse($request->input('tgl_sewa.end')))+1;
        
        $total=($request->biaya_investor+$request->biaya_danlap+$request->biaya_bbmtol+$request->biaya_driver)*$hari;
        $booking['biaya_adm'] = $request->biaya_investor*10/100*$hari;
        $booking['biaya'] = $total;
        $booking['hari'] = $hari;
        $booking['sisa_tagihan'] = $total;


        //noinvoice
        $mmyy = substr($request->input('tgl_sewa.start'), 0, 7);
        $mm = substr($request->input('tgl_sewa.end'), 5, 2);
        $yy = substr($request->input('tgl_sewa.end'), 0, 4);

        $romawi = $this->getRomawi($mm);

        $nourut = substr(DB::table('bookings')->select('noinvoice')->whereRaw('DATE_FORMAT(awal_sewa,"%Y-%m") = ?' , [$mmyy])->orderBy('noinvoice', 'DESC')->limit(1)->value('noinvoice'), 0, 3);

        if ($nourut <= 000) {
            $nourut = 1;
        } else {
            $nourut = $nourut+1;
        }

        $noinvoice = sprintf("%03d", $nourut).'/SKY-INV'.'/'.$romawi.'/'.$yy;
        $booking['noinvoice'] = $noinvoice; 
        $booking['status_tagihan'] = 1; 

        // pelanggan baru
        if ($request->pelanggan_radio == 1) {
            $this->validate($request, [
                'foto_identitas'  => 'required|max:512|mimes:jpeg,jpg',
            ]);

            $last_pelanggan = pelanggan::select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
            $idf = $last_pelanggan+1;

            $filename = $idf.Str::random(16).'.'.$request->foto_identitas->extension();
            $path ='';

            if ($request->foto_identitas!=null) {
                $path = $request->file('foto_identitas')->storeAs('foto_identitas', $filename);
                $pelanggan['foto_identitas'] = $path;
            }

            $pelanggan['nama'] = $request->nama;
            $pelanggan['jenis_identitas_id'] = $request->jenis_identitas;
            $pelanggan['no_identitas'] = $request->no_identitas;
            $pelanggan['alamat'] = $request->alamat;
            $pelanggan['alias'] = $request->alias;
            $pelanggan['group'] = $request->group;
            $pelanggan['kenalan'] = $request->kenalan;
            $nama_pelanggan = $request->nama;
            $nama_pelanggan = $request->alamat;
            $pelanggana = pelanggan::create($pelanggan);

            $booking['pelanggan_id'] = $idf;
        }else {
            $this->validate($request, [
                'pelanggan'  => 'required',
            ]);
            $nama_pelanggan = pelanggan::where('id', $request->pelanggan)->value('nama');
            $alamat = pelanggan::where('id', $request->pelanggan)->value('alamat');
            $booking['pelanggan_id'] = $request->pelanggan;
        }


        //buat file tagihan
        $mobil = mobil::where('id', $request->mobil)->first();
        $tgl_invoice = Carbon::now()->isoFormat('D MMMM Y');
        $last_booking = booking::select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $idb = $last_booking+1;
        $filename = $idb.Str::random(16);
        $template_document = new TemplateProcessor(Storage::path('format/tagihan.docx'));
        $saveDocPath = Storage::path('tagihan/'.$filename.'.docx');
        $template_document->setValue('noinvoice', $noinvoice);
        $template_document->setValue('nama', $nama_pelanggan);
        $template_document->setValue('tgl_invoice', $tgl_invoice);
        $template_document->setValue('alamat', $alamat);
        $template_document->setValue('total', $total);
        $template_document->setValue('tgl', $request->input('tgl_sewa.start').' s/d '.$request->input('tgl_sewa.end'));
        $template_document->setValue('mobil', $mobil->tipe.' '.$mobil->plat);
        $template_document->setValue('driver', $driver);
        $template_document->setValue('bbmtol', $bbmtol);
        $template_document->setValue('hari', $hari);
        $template_document->setValue('hrgmobil', $request->biaya_investor+$request->biaya_danlap);
        $template_document->setValue('hrgdriver', $request->biaya_driver);
        $template_document->setValue('hrgbbmtol', $request->biaya_bbmtol);
        $template_document->setValue('hargamobil', ($request->biaya_investor+$request->biaya_danlap)*$hari);
        $template_document->setValue('hargadriver', $request->biaya_driver*$hari);
        $template_document->setValue('hargabbmtol', $request->biaya_bbmtol*$hari);
        $template_document->saveAs($saveDocPath);
        $converter = new OfficeConverter($saveDocPath);
        $converter->convertTo($filename.'.pdf'); 
        Storage::delete('tagihan/'.$filename.'.docx');
        $booking['file_tagihan'] = 'tagihan/'.$filename.'.pdf'; 

        //simpan data booking
        $book = booking::create($booking);

        return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking berhasil ditambahkan'), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('boilerplate::booking.show', [
            'wilayah' => wilayah::where(DB::raw('CHAR_LENGTH(kode)'), 2)->get()->all(),
            'driver' => driver::where([['status', '=', 1], ['sedia_status', '=', 1]])->get()->all(),
            'jenis_identitas' => jenis_identitas::where('status', 1)->get()->all(),
            'booking' => booking::leftJoin('jenis_pakets', 'jenis_pakets.id', 'bookings.jenis_paket_id')->leftJoin('pelanggans', 'pelanggans.id', 'bookings.pelanggan_id')->leftJoin('mobils','mobils.id', 'bookings.mobil_id')->where([['bookings.id', '=', $id], ['bookings.status', '=', 1]])->get([
                'bookings.*',
                'pelanggans.nama',
                DB::raw('concat(left(no_identitas, 2), "*******", right(no_identitas, 2)) as no_identitas'),
                'pelanggans.jenis_identitas_id',
                'pelanggans.alamat',
                'pelanggans.alias',
                'pelanggans.group',
                'pelanggans.kenalan',
                DB::raw('concat(merek, " ", tipe, " ", plat) as mobil'),
                'jenis_paket',
            ])->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('boilerplate::booking.edit', [
            'wilayah' => wilayah::where(DB::raw('CHAR_LENGTH(kode)'), 2)->get()->all(),
            'driver' => driver::where([['status', '=', 1], ['sedia_status', '=', 1]])->get()->all(),
            'jenis_identitas' => jenis_identitas::where('status', 1)->get()->all(),
            'booking' => booking::leftJoin('jenis_pakets', 'jenis_pakets.id', 'bookings.jenis_paket_id')->leftJoin('pelanggans', 'pelanggans.id', 'bookings.pelanggan_id')->leftJoin('mobils','mobils.id', 'bookings.mobil_id')->where([['bookings.id', '=', $id], ['bookings.status', '=', 1]])->get([
                'bookings.*',
                'pelanggans.nama',
                DB::raw('concat(left(no_identitas, 2), "*******", right(no_identitas, 2)) as no_identitas'),
                'pelanggans.jenis_identitas_id',
                'pelanggans.alamat',
                'pelanggans.alias',
                'pelanggans.group',
                'pelanggans.kenalan',
                DB::raw('concat(merek, " ", tipe, " ", plat) as mobil'),
                'jenis_paket',
            ])->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = booking::where('id', $id)->first();
        $input['status'] = 0;
        $driver = $input->save();
    }

    public function get_paket(Request $request)
    {
        if ($request->wilayah == 35) {
            $html = '';
            $pakets = biaya_mobil::leftJoin('jenis_pakets', 'jenis_pakets.id', 'biaya_mobils.jenis_paket_id')->where([['biaya_mobils.status' , '=', 1],['jenis_pakets.status', '=', 1], ['mobil_id', '=', $request->mobil_id]])->get(['biaya_mobils.id', 'jenis_paket'])->all();
            $html .= '<option disabled selected value></option>';
            foreach ($pakets as $paket) {
                $html .= '<option value="'.$paket->id.'">'.$paket->jenis_paket.'</option>';
            }
        } else {
            $html = '';
            $pakets = biaya_mobil::leftJoin('jenis_pakets', 'jenis_pakets.id', 'biaya_mobils.jenis_paket_id')->where([['biaya_mobils.status' , '=', 1],['jenis_pakets.status', '=', 1], ['jenis_pakets.id', '=', 2], ['mobil_id', '=', $request->mobil_id]])->get(['biaya_mobils.id', 'jenis_paket'])->all();
            $html .= '<option disabled selected value></option>';
            foreach ($pakets as $paket) {
                $html .= '<option value="'.$paket->id.'">'.$paket->jenis_paket.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function get_pelanggans(Request $request)
    {
        if ($request->pelanggan_radio == 1) {
            $html = '<option value="">Silahkan Pilih</option>';
        }else {
            $html = '';
            $pelanggans = pelanggan::where([['status' , '=', 1]])->get(['id', DB::raw('concat(nama, " (", left(no_identitas, 2), "*******", right(no_identitas, 2), ")") as nama')])->all();
            $html .= '<option disabled selected value></option>';
            foreach ($pelanggans as $pelanggan) {
                $html .= '<option value="'.$pelanggan->id.'">'.$pelanggan->nama.'</option>';
            }
        }
        return response()->json(['html' => $html]);
    }
    public function get_pelanggan(Request $request)
    {
        $pelanggan = pelanggan::leftJoin('jenis_identitas', 'jenis_identitas.id', 'pelanggans.jenis_identitas_id')->where([['pelanggans.status' , '=', 1], ['pelanggans.id', '=', $request->pelanggan_id]])->get(['pelanggans.id', 'nama', DB::raw('concat(left(no_identitas, 2), "*******", right(no_identitas, 2)) as no_identitas'), 'alias', 'group', 'alamat', 'kenalan', 'jenis_identitas.id as jid', 'jenis_identitas'])->first();

        return response()->json(
            ['nama' => $pelanggan->nama, 
            'no_identitas' => $pelanggan->no_identitas,
            'jenis_identitas' => '<option value="'.$pelanggan->jid.' selected">'.$pelanggan->jenis_identitas.'</option>',
            'alias' => $pelanggan->alias,
            'group' => $pelanggan->group,
            'alamat' => $pelanggan->alamat,
            'kenalan' => $pelanggan->kenalan]
        );
    }
    public function get_detail_paket(Request $request)
    {
        $paket = biaya_mobil::where([['status' , '=', 1], ['id', '=', $request->jenis_paket_id]])->get(['id', 'biaya_investor', 'biaya_danlap','biaya_driver', 'biaya_bbmtol', 'biaya'])->first();

        return response()->json(
            ['biaya_investor' => $paket->biaya_investor, 
            'biaya_danlap' => $paket->biaya_danlap,
            'biaya_driver' => $paket->biaya_driver,
            'biaya_bbmtol' => $paket->biaya_bbmtol,
            'total_biaya' => $paket->biaya,]
        );
    }

    public function get_mobils(Request $request)
    {
        $html = '';
        $mobils = mobil::whereRaw("NOT EXISTS(
            SELECT * FROM bookings 
            WHERE mobils.id=bookings.mobil_id AND mobils.status=1 AND (
            (awal_sewa BETWEEN ? AND ?) OR 
            (akhir_sewa BETWEEN ? AND ?) OR
            (? BETWEEN awal_sewa AND akhir_sewa) OR
            (? BETWEEN awal_sewa AND akhir_sewa)))", [$request->start, $request->end, $request->start, $request->end, $request->start, $request->end])->get()->all();

        $html .= '<option disabled selected value></option>';
        foreach ($mobils as $mobil) {
            $html .= '<option value="'.$mobil->id.'">'.$mobil->tipe.' '.$mobil->plat.'</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function get_drivers(Request $request)
    {
        $html = '';
        $drivers = driver::whereRaw("NOT EXISTS(
            SELECT * FROM bookings 
            WHERE drivers.id=bookings.driver_id AND drivers.status=1 AND (
            (awal_sewa BETWEEN ? AND ?) OR 
            (akhir_sewa BETWEEN ? AND ?) OR
            (? BETWEEN awal_sewa AND akhir_sewa) OR
            (? BETWEEN awal_sewa AND akhir_sewa)))", [$request->start, $request->end, $request->start, $request->end, $request->start, $request->end])->get()->all();

        $html .= '<option disabled selected value></option>';
        $html .= '<option value="xx">--- Tanpa Driver ---</option>';
        foreach ($drivers as $driver) {
            $html .= '<option value="'.$driver->id.'">'.$driver->nama.'</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function gete_mobils(Request $request)
    {
        $html = '';
        $mobils = mobil::whereRaw("NOT EXISTS(
            SELECT * FROM bookings 
            WHERE mobils.id=bookings.mobil_id AND mobils.status=1 NOT IN(bookings.id=?) AND (
            (awal_sewa BETWEEN ? AND ?) OR 
            (akhir_sewa BETWEEN ? AND ?) OR
            (? BETWEEN awal_sewa AND akhir_sewa) OR
            (? BETWEEN awal_sewa AND akhir_sewa)))", [$request->booking_id, $request->start, $request->end, $request->start, $request->end, $request->start, $request->end])->get()->all();

        $html .= '<option disabled selected value></option>';
        foreach ($mobils as $mobil) {
            $html .= '<option value="'.$mobil->id.'">'.$mobil->tipe.' '.$mobil->plat.'</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function gete_drivers(Request $request)
    {
        $html = '';
        $drivers = driver::whereRaw("NOT EXISTS(
            SELECT * FROM bookings 
            WHERE drivers.id=bookings.driver_id AND drivers.status=1 NOT IN(bookings.id=?) AND (
            (awal_sewa BETWEEN ? AND ?) OR 
            (akhir_sewa BETWEEN ? AND ?) OR
            (? BETWEEN awal_sewa AND akhir_sewa) OR
            (? BETWEEN awal_sewa AND akhir_sewa)))", [$request->booking_id, $request->start, $request->end, $request->start, $request->end, $request->start, $request->end])->get()->all();

        $html .= '<option disabled selected value></option>';
        $html .= '<option value="xx">--- Tanpa Driver ---</option>';
        foreach ($drivers as $driver) {
            $html .= '<option value="'.$driver->id.'">'.$driver->nama.'</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function batal( $id)
    {   
        $input = booking::where('id', $id)->first();
        if ($input->booking_status==1 && $input->booking_status!=4) {
            $input['booking_status'] = 4;
            $driver = $input->save();

            return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking berhasil dibatalkan'), 'success']);
        }
        return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking sedang berjalan atau sudah selesai tidak dapat dibatalkan'), 'danger']);
    }

    public function proses( $id)
    {   
        $input = booking::where([['id', '=',$id], ['status', '=',1]])->first();
        if ($input->booking_status==1) {
            $input['booking_status'] = 2;
            $driver = $input->save();

            return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking berhasil proses sedang berjalan'), 'success']);
        }
        return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking tidak dapat diproses'), 'danger']);
    }

    public function selesai( $id)
    {   
        $input = booking::where([['id', '=',$id], ['status', '=',1]])->first();
        if ($input->booking_status==2) {
            $input['booking_status'] = 3;
            $driver = $input->save();

            return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking berhasil diselesaikan'), 'success']);
        }
        return redirect()->route('boilerplate.booking')
                ->with('growl', [__('Booking tidak dapat diselesaikan'), 'danger']);
    }

    public function bayar( $id)
    { 
        return view('boilerplate::booking.bayar', [
            'tagihan' => booking::where([['status', '=', 1], ['id', '=', $id]])->get()->first(),
        ]);
    }

    public function store_bayar(Request $request, $id)
    {
        $this->validate($request, [
                'pembayaran'  => 'required',
                'bukti_bayar'  => 'required|max:512|mimes:jpeg,jpg',
                'waktu_bayar'  => 'required',
        ]);
        
        $tagihan = booking::where([['status', '=', 1], ['id', '=', $id]])->get()->first();

        $sisa = $tagihan->sisa_tagihan-$request->pembayaran;
        $pembayaran['pembayaran'] = $request->pembayaran;
        $pembayaran['booking_id'] = $tagihan->id;
        $pembayaran['biaya'] = $tagihan->biaya;
        $pembayaran['waktu_bayar'] = $request->waktu_bayar;
        $pembayaran['sisa_tagihan'] = $sisa;
        $pembayaran['keterangan'] = $request->keterangan;
        $tagihan['sisa_tagihan'] = $sisa;

        if ($sisa <=0) {
            $pembayaran['status_tagihan'] = 2;
            $tagihan['status_tagihan'] = 2;
        }elseif ($sisa < $tagihan->biaya) {
            $pembayaran['status_tagihan'] = 3;
            $tagihan['status_tagihan'] = 3;
        }else {
            return redirect()->route('boilerplate.booking', $id)
                ->with('growl', [__('Pembayaran gagal'), 'danger']);
        }

        $filename = $id.Str::random(16).'.'.$request->bukti_bayar->extension();
        $path ='';

        if ($request->bukti_bayar!=null) {
            $path = $request->file('bukti_bayar')->storeAs('bukti_bayar', $filename);
            $pembayaran['bukti_bayar'] = $path;
        }

        $booking = $tagihan->save();
        $bayar = pembayaran::create($pembayaran);
        return redirect()->route('boilerplate.show-booking', $id)
                ->with('growl', [__('Pembayaran berhasil'), 'success']);
    }

    public function delete_bayar($id)
    {   
        $pembayaran = pembayaran::where([['id', '=',$id], ['status', '=',1]])->get()->first();
        $booking = booking::where([['id', '=',$pembayaran->booking_id], ['status', '=',1]])->get()->first();

        $sisa=$pembayaran->pembayaran+$pembayaran->sisa_tagihan;
        $booking['sisa_tagihan'] = $sisa;
        $pembayaran['status'] = 0;
        
        if ($sisa <=0) {
            $booking['status_tagihan'] = 2;
        }elseif ($sisa < $pembayaran->biaya) {
            $booking['status_tagihan'] = 3;
        }elseif ($sisa == $pembayaran->biaya) {
            $booking['status_tagihan'] = 1;
        }
        
        $booking = $booking->save();
        $pembayaran = $pembayaran->save();
    }

    public function get_tagihan(Request $request)
    {
        $booking = booking::where([['status', '=', 1], ['id', '=', $request->id]])->get()->first();
        return response()->json(['id' => $booking->sisa_tagihan, 'status_tagihan' => $booking->status_tagihan]);
    }

    public function cetak_tagihan($id)
    {
        $file= Storage::disk('local')->get(booking::where('id', $id)->value('file_tagihan'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
    }

    public function getRomawi($bulan){
        switch ($bulan){
            case 1: 
                return "I";
            break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }

    public function get_bukti($id)
    {
        $file= Storage::disk('local')->get(pembayaran::where('id', $id)->value('bukti_bayar'));
        return (new Response($file, 200))
            ->header('Content-Type', 'image/jpeg');        
    }
}
