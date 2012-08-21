class Avion extends Vehiculo{
	private $plazas;

	function __construct($patente, origen,$anio,$plazas){
		parent::__construct($patente,$origen,$anio);
		$this->plazas = $plazas;
	}
}