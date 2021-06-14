<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('inicio');
});

//Route::get('peticion', 'acción');
Route::get('/saludo', function () {
    return 'Hola Mundo!!!';
});
Route::get('/prueba', function () {
    return view('primera');
});
#### plantillas
Route::get('/inicio', function () {
    return view('inicio');
});

#### listado de prueba usando raw SQL
Route::get('/listado', function () {
    $regiones = DB::select("SELECT regID, regNombre FROM regiones");
    return view('adminRegiones', ['regiones' => $regiones]);
    //dd($regiones);
});

################################
#### CRUD ####
/**REGIONES */
Route::get('/adminRegiones', function () {
    //obtenemos listado de regiones
    $regiones = DB::select("SELECT regID, regNombre FROM regiones");
    //retornamos la vista pasando dato
    return view('adminRegiones', ['regiones' => $regiones]);
});

//PARA MOSTRAR EL FORM
Route::get('/agregarRegion', function () {
    return view('agregarRegion');
});

//PARA MODIFICAR UNA REGION
//MUESTRO EN EL FORM EL VALOR A MODIFICAR
Route::get(
    '/modificarRegion/{regID}',
    function ($regID) {
        //BUSCO EL ID DE REGION EN LA BDD
        $region = DB::select("SELECT regID, regNombre FROM regiones WHERE regID=?", [$regID]);
        return view('modificarRegion', ['region' => $region]);
    }
);

//HAGO LA MODIFICACION
Route::post('/modificarRegion', function () {
    $regID = $_POST['regID'];
    $name = $_POST['regNombre'];
    $resp = DB::update('UPDATE regiones set regNombre = ? where regID = ?', [$name, $regID]);

    return redirect('/adminRegiones')->with('mensaje', 'Region: ' . $name . ' modificada correctamente');
});

//PARA ENVIAR LOS DATOS
Route::post('/agregarRegion', function () {
    //CAPTURO EL DATO QUE VIENE EN EL FORM
    $name = $_POST['regNombre'];

    //GUARDO EN LA BDD
    DB::insert('INSERT INTO regiones (regNombre) VALUES (?)', [$name]);

    //REDIRIJO AL LISTADO PRINCIPAL DE REGIONES SI ESTA TODO OK
    return redirect('/adminRegiones')->with('mensaje', 'Region: ' . $name . ' agregada correctamente');
});

//PARA ELIMINAR UNA REGION
//MUESTRO EN EL FORM LA REGION A ELIMINAR
Route::get('/eliminarRegion/{regID}', function ($regID) {
    //BUSCO EL VALOR EN LA TABLA
    $Region = DB::table('regiones')->where('regID', '=', $regID)->first();

    //RETORNO EL VALOR
    return view('/eliminarRegion', ['Region' => $Region]);
});

//ELIMINO EL REGISTRO
Route::post('/eliminarRegion', function () {
    //TOMO EL VALOR
    $regID = $_POST['regID'];
    $regNombre = $_POST['regNombre'];

    //HAGO EL DELETE
    DB::table('regiones')->where('regID', '=', $regID)->delete();

    //REDIRIJO A LA PAGINA PRINCIPAL DE REGIONES
    return redirect('/adminRegiones')->with(
        'mensaje',
        'Region: ' . $regNombre . ' eliminada correctamente'
    );
});

/**DESTINOS */
//LIST DESTINOS
Route::get('/adminDestinos', function () {
    $destinos = DB::select("SELECT destID, destNombre,regNombre,destPrecio
    FROM agencia.regiones r, agencia.destinos d
    where r.regID=d.regID");
    return view('adminDestinos', ['destinos' => $destinos]);
});


//PARA AGREGAR UN DESTINO
Route::get('/agregarDestino', function () {
    $regiones = DB::select("SELECT regID, regNombre FROM regiones");
    return view('agregarDestino', ['regiones' => $regiones]);
});

Route::post('/agregarDestino', function () {

    //CAPTURAMOS LOS DATOS ENVIADOS EN EL FORM
    $destName = $_POST['destNombre'];
    $regID = $_POST['regID'];
    $destPrecio = $_POST['destPrecio'];
    $destAsientos = $_POST['destAsientos'];
    $destDisponibles = $_POST['destDisponibles'];

    //INSERTAMOS EN LA BDD
    //USANDO RAW SQL
    //DB::insert('INSERT INTO destinos (id, name) values (?, ?)', [1, 'Dayle']);

    //USANDO QUERY BUILDER
    DB::table('destinos')->insert([
        "destNombre" => $destName,
        "regID" => $regID,
        "destPrecio" => $destPrecio,
        "destAsientos" => $destAsientos,
        "destDisponibles" => $destDisponibles
    ]);

    //REDIRIJO AL LISTADO PRINCIPAL DE DESTINOS SI ESTA TODO OK
    return redirect('/adminDestinos')->with('mensaje', 'Destino: ' . $destName . ' agregado correctamente');
});

//PARA MODIFICAR UN DESTINO
Route::get('/modificarDestino/{destID}', function ($destID) {
    //BUSCO EL DESTINO
    $Destino = DB::table('destinos')
        ->where('destID', $destID)
        ->first();

    //OBETENEMOS REGIONES
    $regiones = DB::table('regiones')->get();

    //RETORNO LOS DATOS DEL DESTINO A MODIFICAR
    return view('modificarDestino', ['Destino' => $Destino], ['regiones' => $regiones]);
});

Route::post('modificarDestino', function () {

    //CAPTURAMOS LOS DATOS ENVIADOS EN EL FORM
    $destID = $_POST['destID'];
    $destName = $_POST['destNombre'];
    $regID = $_POST['regID'];
    $destPrecio = $_POST['destPrecio'];
    $destAsientos = $_POST['destAsientos'];
    $destDisponibles = $_POST['destDisponibles'];

    //modificamos
    DB::table('destinos')
        ->where('destID', $destID)
        ->update(
            [
                'destNombre'        =>  $destName,
                'regID'             =>  $regID,
                'destPrecio'        =>  $destPrecio,
                'destAsientos'      =>  $destAsientos,
                'destDisponibles'   =>  $destDisponibles
            ]
        );
    //redirección + mensaje ok
    return redirect('/adminDestinos')
        ->with(['mensaje' => 'Destino: ' . $destName . ' modificado correctamente']);
});

//PARA ELIMINAR UN DESTINO
//MUESTRO EN EL FORM EL DESTINO A ELIMINAR
Route::get('/eliminarDestino/{destID}', function ($destID) {
    //BUSCO EL VALOR EN LA TABLA
    $Destino = DB::table('destinos')->where('destID', '=', $destID)->first();

    //RETORNO EL VALOR
    return view('/eliminarDestino', ['Destino' => $Destino]);
});

//ELIMINO EL REGISTRO
Route::post('/eliminarDestino', function () {
    //TOMO EL VALOR
    $destID = $_POST['destID'];
    $destNombre = $_POST['destNombre'];

    //HAGO EL DELETE
    DB::table('destinos')->where('destID', '=', $destID)->delete();

    //REDIRIJO A LA PAGINA PRINCIPAL DE DESTINOS
    return redirect('/adminDestinos')->with(
        'mensaje',
        'Destino: ' . $destNombre . ' eliminado correctamente'
    );
});
