<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Asistente;
use App\Models\EmailRegistro;

class SendMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asistente = Asistente::select('email', 'llave')->where( 'id', '=', $request->id )->get ();
        $emailDestinatario = $asistente->first()->email;
        $llave = $asistente->first()->llave;

        $emailR = EmailRegistro::select('titulo', 'contenido')->where( 'id_evento', '=', $request->id_evento )->get ();
        $titulo = $emailR->first()->titulo;
        $contenido = $emailR->first()->contenido;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'dieguinv2019@gmail.com';                     // SMTP username
            //$mail->Username   = $correo_remitente;                     // SMTP username
            $mail->Password   = 'sandibell';                              // Password
            //$mail->Password   = $pass_remitente;                              // Password

            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Esto no existia, es para la codificación
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('dieguinv2019@gmail.com', 'Dieguin');
            //$mail->setFrom($correo_remitente, $nombre_remitente);
            //$mail->addAddress('420042e@gmail.com');     // Add a recipient
            $mail->addAddress($emailDestinatario);     // Add a recipient

            // Content
            $mail->Subject = $titulo;
            $mail->Body    =    $contenido.'<br /><br />
                                <img src="cid:qrcode" />';
            $mail->AltBody    = $contenido.'<br /><br />
                                <img src="cid:qrcode" />';

            $result_qr_content_in_png = \QrCode::format('png')
                ->size(200)
                ->generate($llave);
            
            $mail->addStringEmbeddedImage($result_qr_content_in_png, 'qrcode', 'qrcode.png');

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
