<?php
    trait DataAccess{
        public function __call($method, $args) {
            $campo = lcfirst(substr($method, 3));
            if (strpos($method, 'set') === 0) {
                $this->$campo = $args[0];
                return;
            } elseif(strpos($method, 'get') === 0) {
                return $this->$campo;
            }
            throw new Exception('Método indefinido');
        }
    }
?>