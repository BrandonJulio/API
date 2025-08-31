<?php
    //Conexión a la base de datos
    class productsModel{
        public $conexion;
        public function __construct(){
            $this->conexion = new mysqli('localhost','root','','api');
            mysqli_set_charset($this->conexion,'utf8');
        }

        //Obtener productos
        //array Lista de productos
        public function getProducts($id=null){
            $where =($id = null) ? " WHERE id=$id" : "";
            $products =[];
            $sql= "SELECT * FROM products ".$where;
            $registos = mysqli_query($this->conexion,$sql);
            while($row = mysqli_fetch_assoc($registos)){
                array_push($products,$row);
            }
            return $products;
        }

        //Guardar un nuevo producto en la base de datos
        //array Resultado de la operación [status, mensaje]
        public function saveProducts($name,$description,$price){
            $valida = $this->validateProducts($name,$description,$price);
            $resultado = ['error','Ya existe un producto con las mismas características'];
            if(count($valida)==0){
                $sql="INSERT INTO products (name,description,price) VALUES ('$name','$description',$price)";
                mysqli_query($this->conexion,$sql);
                $resultados = ['succes','Producto guardado'];
            }    
            return $resultados;
        }

        //Actualizar un producto en la base de datos
        public function updateProducts($id,$name,$description,$price){
            $existe = $this->getProducts($id);
            $resultado = ['error','No existe el producto con el ID'.$id];
            if(count($existe)>0){
            $valida = $this->validateProducts($name,$description,$price);
            $resultado = ['error','Ya existe un producto con las mismas características'];
                if(count($valida)==0){
                    $sql="UPDATE products SET name='$name',description='$description',price=$price WHERE id=$id";
                    mysqli_query($this->conexion,$sql);
                    $resultados = ['succes','Producto actualizado'];
                }
        }
            return $resultados;
        }

        //Eliminar un producto por su ID
        public function deleteProducts($id){
            $valida = $this->getProducts($id);
            $resultado = ['error','El ID del producto no existe'.$id];
            if(count($valida)>0){
                $sql="DELETE FROM products WHERE id=$id";
                mysqli_query($this->conexion,$sql);
                $resultados = ['succes','Producto eliminado'];
            }      
            return $resultados;
        }

        //Validar si existe un producto con las mismas características
        public function validateProducts($name,$description,$price){
            $products =[];
            $sql= "SELECT * FROM products WHERE name='$name' AND description='$description' AND price=$price";
            $registos = mysqli_query($this->conexion,$sql);
            while($row = mysqli_fetch_assoc($registos)){
                array_push($products,$row);
            }
            return $products;
        }
    }
?>