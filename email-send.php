<?php

/*$to='bhattacharyyagoutam4@gmail.com,roy.souvik77@gmail.com';
	  
$name = $_POST['name'];
	$email = 'ddddd';
	$phone = '33333';
	$comments = 'test';
	
	$from = 'bhattacharyyagoutam4@gmail.com';
	
	$subject = "Dineshgain.com :: One visitor have posted his/her info from 'Contact Me'.";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: ' . $from . "\r\n";

	$message = '<table width="70%" cellspacing="0" cellpadding="3" border="1" style="border-collapse:collapse; border:1px solid #86BFE8" bordercolor="#86BFE8">
					<tr>
						<td align="left" colspan="2"><b>Sender Details:</b></td>
					</tr>
					<tr>
						<td align="left"><b>Name:</b></td>
						<td align="left">'.$name.'</td>
					</tr>';
					
					
	if($phone !=''){				
	$message .=		'<tr>
						<td align="left"><b>Phone:</b></td>
						<td align="left">'.$phone.'</td>
					</tr>';
		}
					
	if($email !=''){				
	$message .=		'<tr>
						<td align="left"><b>Email:</b></td>
						<td align="left">'.$email.'</td>
					</tr>';
		}			
	if($comments !=''){				
	$message .=		'<tr>
						<td align="left"><b>Comments: </b></td>
						<td align="left">'.$comments.'</td>
					</tr>';
		}	
	
				
	$message .='</table>';
							
	@mail($to, $subject, $message, $from);*/
	
	$to ='anangahelp@yahoo.com,roygroup.ananga@gmail.com';
	$from_admin ="ramani88@yahoo.co.in";
	  $subject = "Iphone.com :: Registration";
	  $headers  = 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  $headers .= 'From: ' . $from_admin . "\r\n";
	
	  $message = 'Desting message'."\r\n".$to;
	 
	
	@mail($to, $subject, $message, $from_admin);
	
?>