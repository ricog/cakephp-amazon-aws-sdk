<?php
Configure::load('Amazonsdk.amazon');

/**
 * AmazonComponent
 *
 * Provides an entry point into the Amazon SDK.
 */
class AmazonComponent extends Component {

  /**
   * Holds an array of valid service "names" and the class that corresponds
   * to each one.
   *
   * @var array
   * @access private
   */
  private $__services = array(
    'SNS' => 'AmazonSNS',
    'AutoScale' => 'AmazonAS',
    'CloudFront' => 'AmazonCloudFront',
    'CloudWatch' => 'AmazonCloudWatch',
    'EC2' => 'AmazonEC2',
    'ELB' => 'AmazonELB',
    'EMR' => 'AmazonEMR',
    'RDS' => 'AmazonRDS',
    'S3' => 'AmazonS3',
    'SDB' => 'AmazonSDB',
    'SQS' => 'AmazonSQS'
  );

  /**
   * Constructor
   * saves the controller reference for later use
   * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
   * @param array $settings Array of configuration settings.
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    $this->_controller = $collection->getController();
    parent::__construct($collection, $settings);
  }
  
  /**
   * Initialization method. Triggered before the controller's `beforeFilfer`
   * method but after the model instantiation.
   *
   * @param Controller $controller
   * @param array $settings
   * @return null
   * @access public
   */
  public function initialize(Controller $controller) {
    // Handle loading our library firstly...
    App::build(array('Vendor' => array(
      APP.'Plugin'.DS.'Amazonsdk'.DS .'Vendor'.DS)
    ));    
    App::import('Vendor', 'Amazon', array(
      'file' => 'sdk-1.5.6'.DS.'sdk.class.php'
    ));
  }

  /**
   * PHP magic method for satisfying requests for undefined variables. We
   * will attempt to determine the service that the user is requesting and
   * start it up for them.
   *
   * @var string $variable
   * @return mixed
   * @access public
   */
  public function __get($variable) {
    if (in_array($variable, array_keys($this->__services))) {

      // Store away the requested class for future usage.
      $this->$variable = $this->__createService(
        $this->__services[$variable]
      );

      // Return the class back to the caller
      return $this->$variable;
    }
  }

  /**
   * Instantiates and returns a new instance of the requested `$class`
   * object.
   *
   * @param string $class
   * @return object
   * @access private
   */
  private function __createService($class) {
    return new $class(array(
      'key' => Configure::read('Aws.key'),      
      'secret' => Configure::read('Aws.secret'),
      'certificate_authority' => Configure::read('Aws.certificate_authority'),
    ));
  }  

}