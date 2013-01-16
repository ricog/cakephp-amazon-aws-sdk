# Amazon Plugin for CakePHP 2.0+

This plugin is a (*very*) thin veil over Amazon's [AWS SDK for PHP](http://aws.amazon.com/sdkforphp/) for use in CakePHP controllers.
Forked from http://github.com/joebeeson/amazon for CakePHP 1.3+

## Installation

* Download the plugin

        $ cd /path/to/your/app/plugins && git clone git://github.com/mcallisto/cakephp_amazon_aws_sdk.git

* Add the component to a controller

		public $components = array('Amazonsdk.Amazon');

## Configuration

You must set Aws.key, Aws.secret, and optionally Aws.certificate_authority in your application
config. Below is an example. This can be added in bootstrap.php. Make sure to change the defaults.

Configure::write('Aws', array(
	'key' => 'YOUR_KEY',
	'secret' => 'YOUR_SECRET',
	'certificate_authority' => false
));

## Usage

At this point you have access to all of the methods available from the AWS SDK. The library currently has support for the following services:

* Amazon CloudFront
* Amazon CloudWatch
* Amazon DynamoDB
* Amazon ElastiCache
* Amazon Elastic Compute Cloud (Amazon EC2)
* Amazon Elastic MapReduce
* Amazon Relational Database Service (Amazon RDS)
* Amazon Simple Notification Service (Amazon SNS)
* Amazon Simple Queue Service (Amazon SQS)
* Amazon Simple Storage Service (Amazon S3)
* Amazon Simple Workflow Service
* Amazon SimpleDB
* Amazon Simple Email Service
* Amazon Virtual Private Cloud (Amazon VPC)
* Auto Scaling
* AWS CloudFormation
* AWS Elastic Beanstalk
* AWS Import/Export
* AWS Identity and Access Management
* Elastic Load Balancing

Not all of the methods for each service has been thoroughly tested. If you run into any issues, feel free to open an issue here, on the repository.

The specific objects for each service can be accessed through the component as a member of it. Here are some examples:

* `$this->Amazon->SNS`
* `$this->Amazon->AutoScale`
* `$this->Amazon->CloudFront`
* `$this->Amazon->CloudWatch`
* `$this->Amazon->EC2`
* `$this->Amazon->ELB`
* `$this->Amazon->RDS`
* `$this->Amazon->EMR`
* `$this->Amazon->SDB`
* `$this->Amazon->SQS`

## Example

To publish to the Simple Notification Service the method to use is called `publish` -- here is an example:

		$this->Amazon->SNS->publish('arn:aws:sns:us-east-1:567053558973:foo', 'This is the message to publish');

To lookup any EC2 instances, we can do the following:

		$response = $this->Amazon->EC2->describe_instances();

Lets say we wanted to upload a file to S3:

		$this->Amazon->S3->create_object(
			'our_bucket',
			'filename.jpg',
			array(
				'fileUpload' => '/tmp/image.jpg',
				'acl' => AmazonS3::ACL_PUBLIC
			)
		);

## Notes

Almost all of the methods that can be performed against a service will return a `CFResponse` object. The plugin makes no attempt to translate this into anything other than an object since the response is directly generated from the API response. For more information on the `CFResponse` object [click here](http://docs.amazonwebservices.com/AWSSDKforPHP/latest/index.html#i=CFResponse)
