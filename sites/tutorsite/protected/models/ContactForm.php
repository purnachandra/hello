<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $mobile;
	public $body;
	public $validacion;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, mobile, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			array('message,subject','safe'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		/*	array('validacion', 
               'application.extensions.recaptcha.EReCaptchaValidator', 
               'privateKey'=>'6LcNWuISAAAAAE_36j1F3h4ecfwRt_zg7B9yrGL5','on' => 'registerwcaptcha' ),*/
			
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'validacion'=>'Verification Code',
                        'name' => 'Your Name',
                        'email' => 'Your Email Id',
			'mobile' => 'Your Mobile Number',
			'subject' => 'Subject of the message',
                        'body' => 'Message Details',
                       
		);
	}
}