<?php
/**
 * IP Checker class.
 *
 * Process the given IP and returns a message if the IP already exists in a .json file.
 */

#OPTIONAL: Change default timezone.
date_default_timezone_set('America/Santiago');
    
class IPChecker {
    private $ip;
        
    const FILE = 'record.json';
        
    /**
     *  __construct() function.
     *
     * @param1 string $ip IP Address.
     */
    public function __construct(string $ip)
    {
        $this->ip = $ip;
        if (!file_exists(self::FILE))
            fopen(self::FILE, 'w');
    }
        
    /**
     * Check function.
     *
     * Given an IP address, this function check if that IP already exists in the file.
     */
    public function check() : string
    {
        $data       = json_decode(file_get_contents(self::FILE), true);
        $day        = date("d-m-Y", time());
        $return     = null;
            
        if(!array_key_exists($day, $data))
            $data[$day] = null;
            
        if(in_array($this->ip, $data[$day]))
            return 'IP ('.$this->ip.') already exists.';

        if($this->match($data))
            $return .= 'This IP ('.$this->ip.') is not used today but also exists in the whole record. Be careful.';
        else
            $return .= 'This IP ('.$this->ip.') is new. Now it\'s stored in the list.';
            
        $data[$day][] = $this->ip;
              
        $data = json_encode($data);
        file_put_contents(self::FILE, $data);
            
        return $return;
    }
        
    private function match(array $data) : bool
    {
        foreach ($data as $d) {
            if (in_array($this->ip, $d))
                return true;
        }
        return false;
    }
}