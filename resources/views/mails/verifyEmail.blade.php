<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<header>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</header>
<body>
<div class="l_mail_template" style="display: block; width: 600px; margin: 0 auto; border: 1px solid #f3f3f3; padding: 30px 15px">
    <table class="head-wrap" style="margin:0 auto 20px">
        <tr>
            <td></td>
            <td class="header container" >
                <div class="content">
                    <table>
                        <tr>
                            <td><img class="mail-logo" src="{{env('APP_URL')}}/public/images/Logo.svg"  alt="" style="width: 300px"></td>
                        </tr>
                    </table>
                </div>

            </td>
            <td></td>
        </tr>
    </table>

    <table class="body-wrap">
        <tr>
            <td class="container">
                <div class="">
                    <table>
                        <tr>
                            <td>
                                <p>{{__('email.verify email.hi')}} {{$user->name}},</p>
                                <p>
                                    {{__('email.verify email.description')}}
                                </p>
                                <table role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:30px auto;padding:0;text-align:center;width:100%">
                                    <tbody>
                                        <tr>
                                            <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                                                <table role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                                                    <tbody><tr>
                                                        <td align="center" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                                                            <table role="presentation" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                                                                <tbody><tr>
                                                                    <td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                                                                        <a href="{{$url}}" class="m_6258672831359649979button" rel="noopener" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://localhost:8000/api/email/verify/12/1327378ea807c4aac579d5926634ad5201d93aeb?expires%3D1699871793%26signature%3D18ecca9bd2fd767bb45663ca26291999e2b8df940d2bc8ae072c8cc23cc243f4&amp;source=gmail&amp;ust=1699954622703000&amp;usg=AOvVaw3aLhwPfaoaHAwuRL5CKehx">{{__('email.verify email.link')}}</a>
                                                                    </td>
                                                                </tr>
                                                                </tbody></table>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

    </table>

</div>
</body>

</html>