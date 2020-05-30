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
        $this->Cell(40,10,'Expediente del Trabajador',0,1,'C');
        
        
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

    $consulta = "SELECT * FROM personalmedico WHERE correo = '$varSesion'";
    $resultado = mysqli_query($conexion, $consulta);
   
// Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',11); 
    
    $pdf->Cell(190, 10, 'Datos del Personal Medico', 1, 1, 'C');

    $row = $resultado->fetch_assoc(); // Se guarda toda la fila
    $iv = $row['iv']; // SSe obtiene el vvector de inicializacion
        //Se decifra cada elemento de la fila
        $pdf->Cell(50, 10, 'Identificador: THC-'. $row['id'], 1, 1, 'C');
        $pdf->Cell(190, 10, 'Correo Electronico: '.$row['correo'], 1, 1, 'C');
        $pdf->Cell(63, 10, 'Nombre(s): '.decrypt_aes($row['nombre'], $key, $iv), 1, 0, 'I');
        $pdf->Cell(63, 10, 'Apellido Paterno: '.decrypt_aes($row['apellidoP'], $key, $iv), 1, 0, 'L');
        $pdf->Cell(63, 10, 'Apellido Materno: '.decrypt_aes($row['apellidoM'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(90, 10, 'Tipo de Personal: '.decrypt_aes($row['tipoPersonal'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(190, 10, 'Direccion: '.decrypt_aes($row['direccion'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(90, 10, 'Codigo Postal: '.decrypt_aes($row['cp'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(90, 10, 'Telefono: '.decrypt_aes($row['telefono'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(90, 10, 'CURP: '.decrypt_aes($row['curp'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(90, 10, 'RFC: '.decrypt_aes($row['rfc'], $key, $iv), 1, 1, 'L');
        $pdf->Cell(90, 10, 'Area a la que pertenece: '.decrypt_aes($row['area'], $key, $iv), 1, 1, 'L');     

    ob_end_clean();
    $pdf->Output(); //Se manda a llamar el pdf
    
?>