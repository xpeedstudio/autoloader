<?php 
namespace XpeedStudio;

class Autoloader{

    private $namespace;

    private $classdir;
    
	/**
	 * Run autoloader.
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  string $namespace
	 * @param  string $classdir
	 * @return void
	 */
	public function __construct( $namespace = null, $classdir = '' ){
        if($namespace == null){
            return;
        }
        $this->namespace = $namespace;

        $this->classdir = trailingslashit($classdir);

		spl_autoload_register( [ $this, 'autoload' ] );
    }
    
    /**
	 * Autoload.
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.0.0
	 * @access private
	 * @param string $class Class name.
	 */
	private function autoload( $class_name ) {

        // If the class being requested does not start with our prefix
        // we know it's not one in our project.
        if ( 0 !== strpos( $class_name, $this->namespace ) ) {
            return;
        }
        
        $file_name = strtolower(
            preg_replace(
                [ '/\b'.$this->namespace.'\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                [ '', '$1-$2', '-', DIRECTORY_SEPARATOR],
                $class_name
            )
        );

        // Compile our path from the corosponding location.
        $file = $this->classdir . $file_name . '.php';
        
        // If a file is found.
        if ( file_exists( $file ) ) {
            // Then load it up!
            require_once( $file );
        }
    }
}
