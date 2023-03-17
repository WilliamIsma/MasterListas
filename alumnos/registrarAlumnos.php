
<?php 
// Base de Datos
require '../includes/config/database.php'; 
$db = conectarDB();

// Array con mensajes de errores
$errores = [];

$cuenta = '';
$nombre = '';
$sexo = '';
$correo = '';
$telefono = '';
$carrera = '';
$tutor = '';
$dependencia = '';

// Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';

  $cuenta = $_POST['cuenta'];
  $nombre = strtoupper($_POST['nombre']);
  $sexo = strtoupper($_POST['sexo']);
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $carrera = $_POST['carrera'];
  $tutor = $_POST['tutor'];
  $dependencia = $_POST['dependencia'];

  if(strlen($cuenta) < 7) {
    $errores['cuenta'][] = "Debes añadir una cuenta valida";
  } else if (strlen($cuenta) > 7) {
    $errores['cuenta'][] = "No te puedes pasar de los 7 digitos";
  }

  if(!$nombre) {
    $errores['nombre'][] = "Nombre obligatorio";
  }

  if(!$sexo) {
    $errores['sexo'][] = "Seleccione sexo";
  }

  if(!$correo) {
    $errores['correo'][] = "Correo obligatorio";
  }

  if(!$telefono) {
    $errores['telefono'][] = "Telefono obligatorio";
  }

  if(!$carrera) {
    $errores['carrera'][] = "Carrera obligatorio";
  }

  if(!$tutor) {
    $errores['tutor'][] = "Tutor obligatorio";
  }

  if(!$dependencia) {
    $errores['dependencia'][] = "Dependencia obligatorio";
  }

  // echo '<pre>';
  // var_dump($errores);
  // echo '</pre>';

  // exit;

  // Revisar que el array de errores este vacio
  if(empty($errores)) {
    // INSERTAR EN LA BD
  $query = "INSERT INTO Alumnos (cuenta, nombre, sexo, correo, telefono, idCarrera, idTutor, idDependencias) VALUES ( '$cuenta', '$nombre', '$sexo', '$correo', '$telefono', '$carrera', '$tutor', '$dependencia' )";

  // echo $query;

  $resultado = mysqli_query($db, $query);

  if($resultado) {
    // echo "Insertado correctamente";

    // Muestra una alerta SweetAlert2 de éxito
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>';
    echo '<script>';
    echo 'Swal.fire({';
    echo '  icon: "success",';
    echo '  title: "¡Guardado!",';
    echo '  text: "El formulario se ha enviado correctamente",';
    echo '  footer: "Nombre: '.$nombre.'<br>Email: '.$correo.'"';
    echo '});';
    echo '</script>';

    // header('Location: ../panelAdministrativo/dashboard.php');
  }
}
  }

  

// CONSULTA DE TABLA Tutor
$query_Tutor = "SELECT idTutor, nombreTutor, denominacion FROM Tutor";

$resultado_Tutor = mysqli_query($db, $query_Tutor);

$tutores = array();
while ($fila = mysqli_fetch_array($resultado_Tutor)) {
    $tutores[] = $fila;
}

// CONSULTA DE TABLA Dependencias
$query_Dependencia = "SELECT idDependencias, nombreDep FROM Dependencias";

$resultado_Dependencias = mysqli_query($db,$query_Dependencia);

$dependencias = array();
while ($fila = mysqli_fetch_array($resultado_Dependencias)) {
  $dependencias[] = $fila;
}

// CONSULTA DE TABLA Carrera
$query_Carrera = "SELECT idCarrera, carrera, abreviatura FROM Carrera";

$resultado_Carreras = mysqli_query($db,$query_Carrera);

$carreras = array();
while ($fila = mysqli_fetch_array($resultado_Carreras)) {
  $carreras[] = $fila;
}

// mysqli_close();




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Logo_de_la_UAEMex.svg/1200px-Logo_de_la_UAEMex.svg.png">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Logo_de_la_UAEMex.svg/1200px-Logo_de_la_UAEMex.svg.png">
  <title>
    Alumnos
  </title>
  <?php include '../recursos/recursos.php' ?>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../templates/Menu/menu.php' ?>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
      <div class="container-fluid py-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 ps-2 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="text-white opacity-5" href="javascript:;">Formularios</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Alumnos</li>
          </ol>
          <h6 class="text-white font-weight-bolder ms-2">Alumnos</h6>
        </nav>
        <div class="collapse navbar-collapse me-md-0 me-sm-4 mt-sm-0 mt-2" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Cerrar sesión</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 pe-0 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                  </div>
                </a>
              </a>
            </li>
              </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/fondoAlumnos.jpg'); background-position-y: 95%;">
        <span class="mask bg-gradient-primary opacity-7"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="https://img.icons8.com/color/512/add-user-male-skin-type-7.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                Agregar alumnos
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">

        <div class="col-12 mt-4">
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-1">Favor de llenar todos los campos</h6>
            </div>
            <div class="card-body p-3">
              <div class="row">
                <div class="col-xl-12 col-md-6 mb-xl-0 mb-4">
                  <div class="card card-blog card-plain">
  <form method="POST" action="../alumnos/registrarAlumnos.php">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="cuenta">Numero de cuenta</label>
        <input type="number" class="form-control" name="cuenta" id="cuenta" placeholder="1929132" value="<?php echo $cuenta; ?>">
        <?php if(isset($errores['cuenta'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['cuenta'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="nombre">Nombre completo</label>
        <input type="text" class="form-control text-uppercase" name="nombre" id="nombre" placeholder="Brian David Peralta Arriaga" value="<?php echo $nombre; ?>">
        <?php if(isset($errores['nombre'])): ?>
          <div class="message-error" id="nombre-error" id="nombre-error">
            <?php foreach($errores['nombre'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-6">
      <div class="form-group">
      <label for="exampleFormControlInput1">Sexo</label>
      <select name="sexo" id="sexo" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $sexo === "1" ? 'selected' : '' ?> value="1">Masculino</option>
        <option <?php echo $sexo === "2" ? 'selected' : '' ?> value="2">Femenino</option>
      </select>
      <?php if(isset($errores['sexo'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['sexo'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="correo">Correo</label>
        <input type="email" class="form-control" name="correo" id="correo" placeholder="correo@correo.com" value="<?php echo $correo; ?>">
        <?php if(isset($errores['correo'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['correo'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-6">
      <div class="form-group">
      <label for="telefono">Teléfono</label>
        <input type="number" class="form-control" name="telefono" id="telefono" placeholder="5586092345" value="<?php echo $telefono; ?>">
        <?php if(isset($errores['telefono'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['telefono'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="exampleFormControlInput1">Carrera</label>
      <?php 
        echo '<select name="carrera" id="carrera" class="form-select text-uppercase" aria-label="Default select example">';
        echo '<option value="" selected>-- Selecciona --</option>';
        foreach ($carreras as $carrera) {
            echo '<option value="' . $carrera['idCarrera'] . '">' . $carrera['carrera'] . " " . "- " .$carrera['abreviatura'] . '</option>';
        }
        echo '</select>';
      ?>
      <?php if(isset($errores['carrera'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['carrera'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <!-- <select name="carrera" class="form-select text-uppercase" aria-label="Default select example">
        <option selected>-- Selecciona --</option>
        <option value="1">ico</option>
        <option value="2">lia</option>
        <option value="3">len</option>
        <option value="4">ldi</option>
        <option value="5">lcn</option>
        <option value="6">lde</option>
    </select> -->
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-md-6">
      <div class="form-group">
      <label for="exampleFormControlInput1">Tutor</label>
      <?php 
        echo '<select name="tutor" id="tutor" class="form-select text-uppercase" aria-label="Default select example">';
        echo '<option value="" selected>-- Selecciona --</option>';
        foreach ($tutores as $tutor) {
            echo '<option value="' . $tutor['idTutor'] . '">' . $tutor['denominacion'] . " " . $tutor['nombreTutor'] . '</option>';
        }
        echo '</select>';
      ?>
      <?php if(isset($errores['tutor'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['tutor'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      <!-- <select name="tutor" class="form-select text-uppercase" aria-label="Default select example">
        <option selected>-- Selecciona --</option>
        <option value="1">DR. JUAN BRUNO UBIARCO MALDONADO </option>
    </select> -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="exampleFormControlInput1">Dependencia</label>
      <?php 
        echo '<select name="dependencia" class="form-select text-uppercase" aria-label="Default select example" id="dependencia">';
        echo '<option value="" selected>-- Selecciona --</option>';
        foreach ($dependencias as $dependencia) {
            echo '<option value="' . $dependencia['idDependencias'] . '">' . $dependencia['nombreDep'] . '</option>';
        }
        echo '</select>';
      ?>
      <?php if(isset($errores['dependencia'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['dependencia'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <!-- <select name="dependencia" class="form-select text-uppercase" aria-label="Default select example">
        <option selected>-- Selecciona --</option>
        <option value="1">JUZGADO CIVIL 50° DE PROCESO ESCTRITO </option>
    </select> -->
      </div>
    </div>
  </div>

  <button class="btn btn-icon btn-3 btn-primary" type="submit">
	<span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
  <span class="btn-inner--text"> Agregar</span>
</button>
</form>
                    
                  </div>
                </div>
                
                
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-beetwen">
            <div class="col-lg-12 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                <script>
                  document.write(new Date().getFullYear())
                </script>,
                Software creado por
                <a href="#" class="font-weight-bold">ICO y LIA</a>
                
              </div>
        </div>
      
    </div>
  </div>
</footer>
  
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
  <!-- Incluye SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
</body>

</html>