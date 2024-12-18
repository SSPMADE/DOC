<?php 
class VisitorLog{
    private $db_conn;
    private $http_protocol;
    private $page_url;
    private $reference_url;
    private $user_ip;
    private $user_agent;
    
    function __construct(){
        require_once('db-connect.php');
        $this->db_conn = $conn;
        $server_data = $_SERVER ?? "";
        if(!empty($server_data)){
            // Setting HTTP Protocol (https:// or http://)
            $this->http_protocol = ((!empty($server_data['HTTPS']) && $server_data['HTTPS'] != 'off') || $server_data['SERVER_PORT'] == 443) ? "https://" : "http://";

            // Get Current URL
            $this->page_url = $this->http_protocol . $server_data['HTTP_HOST'] . $server_data['REQUEST_URI'] . $server_data['QUERY_STRING'];

            // Get Reference URL
            $this->reference_url = !empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'/'; 
            // User Agant
            $this->user_agent = $server_data['HTTP_USER_AGENT'];

            // Get User IP Address
            $this->user_ip = $server_data['REMOTE_ADDR'];
        }
    }
    public function log_site_visit(){
        // Query Statement
        $stmt = $this->db_conn->prepare("INSERT INTO `visit_logs` (user_ip, page_url, reference_url, user_agent) VALUES (?, ?, ?, ?)");
        // Binding Insert Values
        $stmt->bind_param('ssss', $this->user_ip, $this->page_url, $this->reference_url, $this->user_agent);
        // Insert Site Visit Log Data into the database
        $save = $stmt->execute();
        if($save){
            // Do something when page visit data has been saved successfully 
            // return true;
        }else{
            // Do something when page visit data has failed to save 
            // return false;
        }
    }
    function __destruct(){
        // Closing Database Connection
        $this->db_conn->close();
    }
}
?>