<?php

require('../fpdf/fpdf.php'); // Archivo que permite generar el documento pdf

class PDF extends FPDF {
// Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('logo.png',20,15,15);
        $this->Image('simbolo.jpg',180,15,15);
        // Arial bold 15
        $this->SetFont('Arial','B',12);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(40,10,'Expediente Medico Electronico',0,1,'C');
        
        
       $this->Cell(200,5,'Hospital las Cumbres S.A. de C.V.',0,1,'C');
       $this->Cell(200,5,utf8_decode('Robles 110, Las Cumbres, Estado de México'),0,1,'C');
       $this->Ln(10);
// Salto de línea$this->Ln(10);     
    }

    // Pie de página
    function Footer()
    {   
        $this->SetY(-25);
        $this->SetFont('Arial','I',8);
        $this->Cell(190, 10, 'Este documento solo puede ser generado por el trabajador del hospital, bajo ninguna circustancia este documento debe ser publico', 1, 1, 'C');

        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

    include '../conexion.php';
    include '../d_aes.php';
    session_start();    
    $varSesion = $_SESSION['usuario'];
    $key = $_POST['key'];
    //Verificar si existe metodo POST
   /* if(){

    }*/
    $consulta = "SELECT * FROM pacientes WHERE correo = '$varSesion'";
    //$resultado = $mysqli->query($consulta);
    $resultado = mysqli_query($conexion, $consulta);
   
   
// Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',11); 
    
    $pdf->Cell(190, 10, 'Datos del paciente', 1, 1, 'C');
       $pdf->Ln(8);

    $row = $resultado->fetch_assoc() ;
    $iv = $row['iv'];

    //while ($row = $resultado->fetch_assoc() ){
        $pdf->Cell(50, 10, 'Expediente: HC-'. $row['numExpediente'], 1, 1, 'C');
        $pdf->Ln(10);
        $pdf->Cell(63, 10, 'Nombre(s): '. decrypt_aes($row['nombre'], $key, $iv), 0, 0, 'I');
        $pdf->Cell(63, 10, 'Apellido Paterno: '.decrypt_aes($row['apellidoP'], $key, $iv), 0, 0, 'L');
        $pdf->Cell(63, 10, 'Apellido Materno: '.decrypt_aes($row['apellidoM'], $key, $iv), 0, 1, 'L');

        $pdf->Cell(190, 10, 'Correo Electronico: '.$row['correo'], 0, 1, 'I');
       
        $pdf->Cell(40, 10, 'Genero: '.decrypt_aes($row['genero'], $key, $iv), 0, 1, 'I');
        $pdf->Cell(40, 10, utf8_decode('Edad: '.$row['edad'].' años'), 0, 1, 'L');
        $pdf->Cell(40, 10, 'Estado Civil: '.decrypt_aes($row['edoCivil'], $key, $iv), 0, 1, 'I');

        $pdf->Cell(63, 10, 'CURP: '.decrypt_aes($row['curp'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'RFC: '.decrypt_aes($row['rfc'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'NSS: '.decrypt_aes($row['nss'], $key, $iv), 0, 1, 'L');
        
        $pdf->Cell(63, 10, 'Numero de Hijos: '.decrypt_aes($row['numHijos'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Lugar de Nacimiento: '.decrypt_aes($row['lugarNac'], $key, $iv), 0, 1, 'L');
       
        $pdf->Cell(190, 10, 'Direccion: '.decrypt_aes($row['direccion'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Codigo Postal: '.decrypt_aes($row['cp'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Telefono: '.decrypt_aes($row['telefono'], $key, $iv), 0, 1, 'L');
        $pdf->Ln(10);
        $pdf->Cell(190, 8, 'Datos Clinicos', 1, 1, 'C');

        $pdf->Ln(5);
        $pdf->Cell(63, 10, 'Alergias: '.decrypt_aes($row['alergias'], $key, $iv), 0, 0, 'L');
        $pdf->Cell(63, 10, 'Altura [mts]:'.$row['altura'], 0, 0, 'L');
        $pdf->Cell(63, 10, 'Peso [kg]:'.$row['peso'], 0, 1, 'L');

        $pdf->Cell(63, 10, 'Grupo Sanguineo: '.decrypt_aes($row['sanguineo'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Consumo de Drogas: '.decrypt_aes($row['drogas'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Medicacion Actual: '.decrypt_aes($row['medicacion'], $key, $iv), 0, 1, 'L');
       

        $pdf->Cell(63, 10, 'Malestar Actual: '.decrypt_aes($row['malestar'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Enfermedades Cronicas:'.decrypt_aes($row['enfermedades'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Parientes Enfermos:'.decrypt_aes($row['parientesEnf'], $key, $iv), 0, 1, 'L');

        $pdf->Cell(63, 10, 'Area Dirigida: '.decrypt_aes($row['area'], $key, $iv), 0, 1, 'L');
        $pdf->Cell(63, 10, 'Tratamiento: '.decrypt_aes($row['tratamiento'], $key, $iv), 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->Cell(190, 10, 'Fecha de creacion de Expediente: '.$row['fecha'], 1, 1, 'C');
    //}

    ob_end_clean();
    $pdf->Output();
    
?>