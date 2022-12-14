<?php

 class EmpleadosModel extends Mysql{
		public $intId;
		public $strNombre;
		public $strEmail;
		public $strSexo;
		public $listArea;
		public $strDescripcion;
        public $listRoles;
		
	public function __construct(){
		parent::__construct();
	}
	

	public function selectEmpleados(){
		$sql = "SELECT * FROM empleado";
		$request = $this->select_all($sql);
		return $request;
	}
    public function selectAreas(){
        $sql = "SELECT * FROM  areas";
        $request = $this->select_all($sql);
        //dep($request);
        return $request;
    }
     public function selectRoles(){
         $sql = "SELECT * FROM roles";
         $request = $this->select_all($sql);
         return $request;
     }
     
     public function insertEmpleado(string $nombre, string $email, string $sexo, int $area, string $descripcion, int $rol  ){
         $return = 0;
         $this->strNombre = $nombre;
		 $this->strEmail = $email;
		 $this->strSexo = $sexo;
		 $this->listArea = $area;
		 $this->strDescripcion = $descripcion;
         $this->listRoles = $rol;
         $sql ="SELECT * FROM empleado WHERE nombre = '{$this->strNombre}' ";
		$request = $this->select_all($sql);
        if(empty($request)){
			$query_insert = "INSERT INTO empleado (nombre,email,sexo, area_id, descripcion) VALUES(?,?,?,?,?)";
			$arrData =  array($this->strNombre,
			 $this->strEmail,
			 $this->strSexo,
             $this->listArea,
             $this->strDescripcion);
			$request_insert = $this->insert($query_insert,$arrData);
            $query_rol= "INSERT INTO empleado_rol (rol_id) VALUES(?)";
            $arrData = array($this->listRoles);
            $request_insert = $this->insert($query_rol,$arrData);
			$return = $request_insert;
		}else{
			$return = "exist";
		}
		return $return;
     }

     public function selectEmpleado($id){
        $this->intId = $id;
		$sql = "SELECT nombre, sexo, area_id, email, descripcion FROM empleado 
        WHERE id = $this->intId";
		$request = $this->select($sql);
		return $request;
     }
     public function deleteEmpleado(int $id){
		$this->intId = $id;
		$sql = "UPDATE empleado SET status = ? WHERE id = $this->intId ";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	  }	
      public function updateEmpleados(int $id, string $nombre, string $email, string $sexo, int $area, string $descripcion){
         $this->intId = $id;
		 $this->strNombre = $nombre;
		 $this->strEmail = $email;
		 $this->strSexo = $sexo;
		 $this->listArea = $area;
		 $this->strDescripcion = $descripcion;
		$sql ="SELECT * FROM empleado WHERE nombre = '{$this->strNombre}' AND id !=  $this->intId ";
		$request = $this->select_all($sql);
		if(empty($request)){
			$sql = "UPDATE empleado SET nombre = ?, email = ?, sexo = ?, area_id= ?, descripcion = ? WHERE id = $this->intId";
			$arrData =  array($this->strNombre,
							  $this->strEmail,
                              $this->strSexo,
                              $this->listArea,
                              $this->strDescripcion,
                            );
			$request = $this->update($sql,$arrData);
		}else{
			$request = "exist";
		}
		return $request;
	}
}

?>