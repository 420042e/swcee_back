<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;

class SendMailUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = User::select('nombre', 'ap_paterno', 'ap_materno', 'email', 'pass')->where( 'id', '=', $request->id )->get ();
        $emailDestinatario = $usuario->first()->email;
        $nombre = $usuario->first()->nombre;
        $ap_paterno = $usuario->first()->ap_paterno;
        $ap_materno = $usuario->first()->ap_materno;
        $pass = $usuario->first()->pass;

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
            $mail->Subject = "Sistema Web de Control de Entrada a Eventos";
            $mail->Body    =    $nombre.', te damos la bienvenida al Sistema Web de Control de Entrada a Eventos<br /><br />'
                                .'Tus credenciales de acceso:<br /><br />'
                                .'Usuario : '.$emailDestinatario.'<br /><br />'
                                .'Contraseña : '.substr($nombre, 0, 3).substr($ap_materno, 0, 3).''.substr($ap_paterno, 0, 3).'<br /><br />'
                                .'Por favor, cambia tu contraseña al ingresar al sistema <br /><br />';
            $mail->AltBody    = $nombre.', te damos la bienvenida al Sistema Web de Control de Entrada a Eventos<br /><br />'
                                .'Tus credenciales de acceso:<br /><br />'
                                .'Usuario : '.$emailDestinatario.'<br /><br />'
                                .'Contraseña : '.substr($nombre, 0, 3).substr($ap_materno, 0, 3).''.substr($ap_paterno, 0, 3).'<br /><br />'
                                .'Por favor, cambia tu contraseña al ingresar al sistema <br /><br />';

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
