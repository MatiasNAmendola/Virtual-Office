<?php
/**
 * String Buffer class.
 * @author Mihael Isaev
 */

class StringBuffer {
    
    /**
     * The string buffer
     * 
     * @access private
     * @var string[];
     */
    private $buffer;
    
    /**
     * Object constructor.
     * 
     * @access public
     * @return void
     */
    public function __construct($arg = null) {
        $this->buffer = array();        
    }
    
    /**
     * Returns the length of the buffer
     * 
     * @access public
     * @return integer
     */
    public function length() {
        return count($this->buffer);
    }
    
    /**
     * Convert the contents of the buffer into a string
     * 
     * @access public
     * @return string
     */
    public function toString() {
        return implode($this->buffer);
    }
    
    /**
     * Appends the string $str to this string buffer.
     * 
     * The characters of the $str argument are appended, in order, to the
     * contents of this string buffer, increasing the length of this string
     * buffer by the length of the argument.
     * 
     * @access private
     * @param string $str
     * @return String_Buffer
     */
    public function append($str) {
        $tmp = str_split($str);
        $this->buffer = array_merge($this->buffer, $tmp);
        return $this;
    }
}
?>