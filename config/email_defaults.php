<?php


return [

    'header' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, Helvetica, sans-serif; color: #333333;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 30px 0;">
        <tr>
            <td align="center">

                <!-- Email Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                       style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="padding: 25px 30px; background-color: #111827; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px;">
                                {site_name}
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                        ',

    'footer' => '
             </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 30px; background-color: #f9fafb; color: #6b7280; font-size: 13px; text-align: center;">

                            <p style="margin: 0 0 8px;">
                                © {year} {site_name}. All rights reserved.
                            </p>

                            <p style="margin: 0;">
                                This is an automated email. Please do not reply directly to this message.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
    ',

];






