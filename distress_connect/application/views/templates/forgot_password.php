<table width="100%" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td width="100%" height="250px" style="background:#AB1B5C;">
				<!-- Header image -->
				<table cellpadding="0" cellspacing="0" width="600" style="margin-left:auto; margin-right:auto; margin-top:151px; text-align:center;">
					<tr>
						<td style=""><h1 style="padding-top:30px; padding-bottom:30px; margin-bottom:0; background:#fff; border-top-left-radius:5px; border-top-right-radius:5px;">Your New Password</h1></td>
					</tr>
				</table>				
			</td>
		</tr>
		<tr>
			<td width="100%" style="background:#f2f2f2;">
				<!-- Header image -->
				<table cellpadding="0" cellspacing="0" width="600" style="margin-left:auto; margin-right:auto; text-align:center;">
					<tr>
						<td style="background:#fff; padding:30px;">
							<p><?php echo "Hello \t: ".$name."\n Your Password has been reset. Please Login using this new password: <i><b>".$password . "</b></i>. It will be valid for 1hour"; ?></p>
							<br>
							<a href="<?php echo site_url('user/login'); ?>" style="font-size:20px; color:#fff; background:#AB1B5C; text-decoration:none; padding:12px 40px; border-radius:5px;">Login</a>
							<br>
							<br>
						</td>
					</tr>
					<tr>
						<td style="background:#111; color:#fff; padding:30px;">
							<h2>! Security</h2>
							<p>For security purpose the above password will be valid for one hour only.</p>
							<p style="font-size:13px;">This is an auto generated message from <i>DISTRESSCONNECT</i>. Please do not replay this email.</p>
						</td>
					</tr>
				</table>				
			</td>
		</tr>
	</tbody>
</table>