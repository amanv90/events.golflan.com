<?php 
include('API_PATH'."/mandrill/src/Mandrill.php");
//$mandrill = new Mandrill('tqr-89BxtEeYGzyhSXJmmg');
//echo "manu";
$this->userObj = new Communicate(DB1);
//$this->userObj->setTaskData($BusinessID, $TaskTypeID, $fields, $TimeStamp, $MailSent);

$arr = $this->userObj->getAllPendingMailTask();
foreach($arr as $tmp)
{
	switch($tmp['businessID'])
	{
			case 1:
					switch($tmp['taskTypeID'])
					{
						case 1:
								//echo "first".$tmp['Task_ID'];
								$pieces = explode(",", $tmp['mailDetails']);
								$RegUserEmail = $pieces[0]; // piece1
								$RegUserFirstName = $pieces[1];
								$CountryISO = $pieces[2];
							
								try {
										$mandrill = new Mandrill('tqr-89BxtEeYGzyhSXJmmg');
										if($tmp['MailTypeID'] == '0')
										{	
											$val = $this->userObj->getTemplateName($tmp['businessID'], $tmp['taskTypeID'], $tmp['MailTypeID']);
											$template_name = $val[0]['TemplateName'];
											$serialNo = $tmp['Task_ID'];   //Serial No. uses here for just update Mail status
											$template_content = array(
												array(
													'name'=>'firstname',
													'content'=>$RegUserFirstName
													),
												array(
													'name'=>'RegUserEmail',
													'content'=>$RegUserEmail
													)
												);
											$message = array(
												'html' => '<p>Example HTML content</p>',
												'text' => 'Example text content',
												'to' => array(
													array(
														'email' => $RegUserEmail,
														'name' => $RegUserFirstName,
														'type' => 'to'
													)
												),
												'headers' => array('Reply-To' => 'message.reply@example.com'),
												'important' => false,
												'track_opens' => null,
												'track_clicks' => null,
												'auto_text' => null,
												'auto_html' => null,
												'inline_css' => null,
												'url_strip_qs' => null,
												'preserve_recipients' => null,
												'view_content_link' => null,
												'bcc_address' => 'message.bcc_address@example.com',
												'tracking_domain' => null,
												'signing_domain' => null,
												'return_path_domain' => null,
												'merge' => true,
												'merge_language' => 'mailchimp',
												'global_merge_vars' => array(
													array(
														'name' => 'merge1',
														'content' => 'merge1 content'
													)
												),
												'merge_vars' => array(
													array(
														'rcpt' => 'recipient.email@example.com',
														'vars' => array(
															array(
																'name' => 'merge2',
																'content' => 'merge2 content'
															)
														)
													)
												)
											);
											$async = false;
											$ip_pool = 'Main Pool';
											$send_at = 'example send_at';
											$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
											$serialNo =$this->userObj->updateTasksStatus($serialNo);
										}
										if($tmp['MailTypeID'] == '1')
										{
											$elapsed = '691200';
											$time_past = $tmp['dateReceived'];
											$time_past = strtotime($time_past);
											$time_past = $time_past + $elapsed;
											$time_now = time();
											if($time_past > $time_now)
											{
												//echo 'Hasnt been 8 days';    
											}else{
												//echo 'Been longer than 8 days';
												$val = $this->userObj->getTemplateName($tmp['businessID'], $tmp['taskTypeID'], $tmp['MailTypeID']);
												$template_name = $val[0]['TemplateName'];
												$serialNo = $tmp['Task_ID'];   //Serial No. uses here for just update Mail status
												$template_content = array(
													array(
														'name'=>'firstname',
														'content'=>$RegUserFirstName
														),
													array(
														'name'=>'RegUserEmail',
														'content'=>$RegUserEmail
														)
													);
												$message = array(
													'html' => '<p>Example HTML content</p>',
													'text' => 'Example text content',
													'to' => array(
														array(
															'email' => $RegUserEmail,
															'name' => $RegUserFirstName,
															'type' => 'to'
														)
													),
													'headers' => array('Reply-To' => 'message.reply@example.com'),
													'important' => false,
													'track_opens' => null,
													'track_clicks' => null,
													'auto_text' => null,
													'auto_html' => null,
													'inline_css' => null,
													'url_strip_qs' => null,
													'preserve_recipients' => null,
													'view_content_link' => null,
													'bcc_address' => 'message.bcc_address@example.com',
													'tracking_domain' => null,
													'signing_domain' => null,
													'return_path_domain' => null,
													'merge' => true,
													'merge_language' => 'mailchimp',
													'global_merge_vars' => array(
														array(
															'name' => 'merge1',
															'content' => 'merge1 content'
														)
													),
													'merge_vars' => array(
														array(
															'rcpt' => 'recipient.email@example.com',
															'vars' => array(
																array(
																	'name' => 'merge2',
																	'content' => 'merge2 content'
																)
															)
														)
													)
												);
												$async = false;
												$ip_pool = 'Main Pool';
												$send_at = 'example send_at';
												$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
												$serialNo =$this->userObj->updateTasksStatus($serialNo);
											}
										}
										//print_r($result);
										//Template For Voucher Applicable User			
										if($CountryISO == "MYS")
										{
													$statusCampaign = '1';
													$valueExistArr = $this->userObj->getVoucherApplicable($tmp['businessID'],$tmp['taskTypeID'],$CountryISO, $statusCampaign);
													if(count($valueExistArr) > 0)
													{	
															$template_name = $valueExistArr[0]['Template1'];
															$VoucherCode = $valueExistArr[0]['Voucher_Code'];
															$template_content = array(
															array(
																'name'=>'firstname',
																'content'=>$RegUserFirstName
																),
															array(
																'name'=>'VoucherCode',
																'content'=>$VoucherCode
																),
															array(
																'name'=>'RegUserEmail',
																'content'=>$RegUserEmail
																)
															);
														$message = array(
															'html' => '<p>Example HTML content</p>',
															'text' => 'Example text content',
															'to' => array(
																array(
																	'email' => $RegUserEmail,
																	'name' => $RegUserFirstName,
																	'type' => 'to'
																)
															),
															'headers' => array('Reply-To' => 'message.reply@example.com'),
															'important' => false,
															'track_opens' => null,
															'track_clicks' => null,
															'auto_text' => null,
															'auto_html' => null,
															'inline_css' => null,
															'url_strip_qs' => null,
															'preserve_recipients' => null,
															'view_content_link' => null,
															'bcc_address' => 'message.bcc_address@example.com',
															'tracking_domain' => null,
															'signing_domain' => null,
															'return_path_domain' => null,
															'merge' => true,
															'merge_language' => 'mailchimp',
															'global_merge_vars' => array(
																array(
																	'name' => 'merge1',
																	'content' => 'merge1 content'
																)
															),
															'merge_vars' => array(
																array(
																	'rcpt' => 'recipient.email@example.com',
																	'vars' => array(
																		array(
																			'name' => 'merge2',
																			'content' => 'merge2 content'
																		)
																	)
																)
															)
														);
														$async = false;
														$ip_pool = 'Main Pool';
														$send_at = 'example send_at';
														$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
													}
										}
								} catch(Mandrill_Error $e) {
									// Mandrill errors are thrown as exceptions
									echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
									// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
									throw $e;
								}
								break;
							
						case 2:
								//echo $tmp['Task_ID'];
								$pieces = explode(",", $tmp['mailDetails']);
								$UserEmail = $pieces[0]; // piece1
								$UserName = $pieces[1];
								$ResetPass = $pieces[2];
							
								try {
										if($tmp['MailTypeID'] == '0')
										{	
											$val = $this->userObj->getTemplateName($tmp['businessID'], $tmp['taskTypeID'], $tmp['MailTypeID']);
											$template_name = $val[0]['TemplateName'];
											$serialNo = $tmp['Task_ID'];
											$template_content = array(
												array(
													'name'=>'username',
													'content'=>$UserName
													),
												array(
													'name'=>'email',
													'content'=>$UserEmail
													),
												array(
													'name'=>'resetpass',
													'content'=>$ResetPass
													)
												);
											$message = array(
												'html' => '<p>Example HTML content</p>',
												'text' => 'Example text content',
												'to' => array(
													array(
														'email' => $UserEmail,
														'name' => $UserName,
														'type' => 'to'
													)
												),
												'headers' => array('Reply-To' => 'message.reply@example.com'),
												'important' => false,
												'track_opens' => null,
												'track_clicks' => null,
												'auto_text' => null,
												'auto_html' => null,
												'inline_css' => null,
												'url_strip_qs' => null,
												'preserve_recipients' => null,
												'view_content_link' => null,
												'bcc_address' => 'message.bcc_address@example.com',
												'tracking_domain' => null,
												'signing_domain' => null,
												'return_path_domain' => null,
												'merge' => true,
												'merge_language' => 'mailchimp',
												'global_merge_vars' => array(
													array(
														'name' => 'merge1',
														'content' => 'merge1 content'
													)
												),
												'merge_vars' => array(
													array(
														'rcpt' => 'recipient.email@example.com',
														'vars' => array(
															array(
																'name' => 'merge2',
																'content' => 'merge2 content'
															)
														)
													)
												)
											);
											$async = false;
											$ip_pool = 'Main Pool';
											$send_at = 'example send_at';
											$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
											$serialNo =$this->userObj->updateTasksStatus($serialNo);
											//print_r($result);
										}
								} catch(Mandrill_Error $e) {
									// Mandrill errors are thrown as exceptions
									echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
									// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
									throw $e;
								}
								break;
							/* workable code Starts here to Sending Mail for EGC Booking
						case 3:
								$pieces = explode(",", $tmp['mailDetails']);
								$EmailID = $pieces[0]; // piece1
								$FName = $pieces[1];
								$LName = $pieces[2];
								$CardNo = $pieces[3];
								$GCName = $pieces[4];
								$City = $pieces[5];
								$CompPlayDate = $pieces[6];
								$CardName = $pieces[7];
							
								try {
										$val = $this->userObj->getTemplateName($tmp['businessID'], $tmp['taskTypeID']);
										$template_name = $val[0]['TemplateName'];
										$serialNo = $tmp['Task_ID'];
										$template_content = array(
											array(
												'name'=>'EmailID',
												'content'=>$EmailID
												),
											array(
												'name'=>'FName',
												'content'=>$FName
												),
											array(
												'name'=>'LName',
												'content'=>$LName
												),
											array(
												'name'=>'CardNo',
												'content'=>$CardNo
												),
											array(
												'name'=>'GCName',
												'content'=>$GCName
												),
											array(
												'name'=>'City',
												'content'=>$City
												),
											array(
												'name'=>'CompPlayDate',
												'content'=>$CompPlayDate
												),
											array(
												'name'=>'CardName',
												'content'=>$CardName
												)
											);
										$message = array(
											'html' => '<p>Example HTML content</p>',
											'text' => 'Example text content',
											'to' => array(
												array(
													'email' => $EmailID,
													'name' => $FName,
													'type' => 'to'
												)
											),
											'headers' => array('Reply-To' => 'message.reply@example.com'),
											'important' => false,
											'track_opens' => null,
											'track_clicks' => null,
											'auto_text' => null,
											'auto_html' => null,
											'inline_css' => null,
											'url_strip_qs' => null,
											'preserve_recipients' => null,
											'view_content_link' => null,
											'bcc_address' => 'message.bcc_address@example.com',
											'tracking_domain' => null,
											'signing_domain' => null,
											'return_path_domain' => null,
											'merge' => true,
											'merge_language' => 'mailchimp',
											'global_merge_vars' => array(
												array(
													'name' => 'merge1',
													'content' => 'merge1 content'
												)
											),
											'merge_vars' => array(
												array(
													'rcpt' => 'recipient.email@example.com',
													'vars' => array(
														array(
															'name' => 'merge2',
															'content' => 'merge2 content'
														)
													)
												)
											)
										);
										$async = false;
										$ip_pool = 'Main Pool';
										$send_at = 'example send_at';
										$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
										$serialNo =$this->userObj->updateTasksStatus($serialNo);
										//print_r($result);

								} catch(Mandrill_Error $e) {
									echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
									throw $e;
								}
								break;
								workable code Ends here to Sending Mail for EGC Booking
							*/
						default:
      							echo "Default";
								break;
							
					}
	}
}

?>
