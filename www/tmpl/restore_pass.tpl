<h2>%title%</h2>
<p>%text%</p>
<p>%message%</p>
<form action="functions.php" method="POST">
    <table>
        <tr>
            <td>Ваш email: </td>
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
            <td>Проверочный код: </td>
            <td>
                <input type="text" name="captcha">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="restorepass" value="Отправить">
            </td>
        </tr>
    </table>
</form>