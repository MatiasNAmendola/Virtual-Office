<?

/**
 * Get information about user
 * Created by Isaev Mihael
 */

class userInfo
{
    getIp(){
      if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        return $_SERVER['HTTP_CLIENT_IP'];
      }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else{
        return $_SERVER['REMOTE_ADDR'];
      }
    }
}