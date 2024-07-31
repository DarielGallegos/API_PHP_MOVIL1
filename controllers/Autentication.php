<?php
class Autentication{
    public function __construct(){}

    public function authenticationUser($user, $passwd){
        $url = 'http://localhost:15000/realms/myRealm/protocol/openid-connect/token';
        $clientId = 'myClient';
        $clientSecret = 'sfnommVTNN0mJuxceDUVyCgQuoPGPk51';

        $data = array(
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $user,
            'password' => $passwd
        );

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 60 // Timeout de 60 segundos
            ),
        );

        $context  = stream_context_create($options);
        
        try {
            $result = @file_get_contents($url, false, $context);
            if ($result === FALSE) {
                throw new Exception('Failed to authenticate');
            }
        } catch (Exception $e) {
            // Puedes registrar el error aquí si es necesario
            // error_log($e->getMessage());
            return json_encode(array('error' => $e->getMessage(), 'access_token' => ""));
        }

        $result = json_decode($result, true);
        return json_encode($result);
    }
}
?>