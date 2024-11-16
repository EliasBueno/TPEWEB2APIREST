<?php

class ApiView {

    // Responde con datos en formato JSON y un código de estado HTTP.
    public function response($data, $status = 200) {
        // Define el tipo de contenido de la respuesta.
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        
        // Convierte los datos a formato JSON y los envía como respuesta.
        echo json_encode($data);
    }

    // Obtiene el texto de estado correspondiente al código HTTP.
    private function _requestStatus($code) {
        $status = array(
            200 => "OK",
            201 => "Created",
            400 => "Bad request",
            401 => "Unauthorized",
            404 => "Not found",
            500 => "Internal Server Error"
        );
        return (isset($status[$code])) ? $status[$code] : $status[500];
    }
}
