classVehiculo {
	private $patente;
	private $origen;
	private $anio;
		
	function __construct($patente, origen,$anio){
		$this->patente = $patente;
		$this->origen = $origen;
		$this->anio = $anio;
	}

	public function verPatente(){
		return this->patente;
	}
}