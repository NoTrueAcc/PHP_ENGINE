<form id="register" action="functions.php" method="post">
    %message%
    <table>
        <tr>
            <td>
                Логин:
            </td>
            <td>
                <input type="text" name="login" value="%login%">
            </td>
        </tr>
        <tr>
            <td>
                Пароль:
            </td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
        <tr>
            <td>
                E-mail:
            </td>
            <td>
                <input type="email" name="email">
            </td>
        </tr>
        <tr>
            <td >
                <img src="%address%/captcha.php" alt="Каптча">
            </td>
        </tr>
        <tr>
            <td>
                Проверочный код:
            </td>
            <td>
                <input type="text" name="captcha">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="reg" value="Зарегистрироваться">
            </td>
        </tr>
    </table>
</form>