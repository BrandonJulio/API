<?php
    class productsModel{
        public $conexion;
        public function __construct(){
            $this->conexion = new mysqli('localhost','root','','api');
            mysqli_set_charset($this->conexion,'utf8');
        }

        public function getProducts(){
            $products =[];
            $sql= "SELECT * FROM products";
            $registos = mysqli_query($this->conexion,$sql);
            while($row = mysqli_fetch_assoc($registos)){
                array_push($products,$row);
            }
            return $products;
        }

        public function saveProducts($name,$description,$price){
            $sql="INSERT INTO products (name,description,price) VALUES ('$name','$description',$price)";
            mysqli_query($this->conexion,$sql);
            $resultados = ['succes','Producto guardado'];
            return $resultados;
        }

        public function updateProducts($id,$name,$description,$price){
            $sql="UPDATE products SET name='$name',description='$description',price=$price WHERE id=$id";
            mysqli_query($this->conexion,$sql);
            $resultados = ['succes','Producto actualizado'];
            return $resultados;
        }

        public function deleteProducts($id){
            $sql="DELETE FROM products WHERE id=$id";
            mysqli_query($this->conexion,$sql);
            $resultados = ['succes','Producto eliminado'];
            return $resultados;
        }
    }
?>