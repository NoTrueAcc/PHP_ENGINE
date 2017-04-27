<h2>%title%</h2>
<p>%text%</p>
<p>%message%</p>
<form action="functions.php" method="POST">
    <table>
        <tr>
            <td>Новый пароль: </td>
            <td>
                <input type="password" name="pass_1">
            </td>
        </tr>
        <tr>
            <td>Повторите ввод пароля: </td>
            <td>
                <input type="password" name="pass_2">
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="secret" value="%secret%">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="restorepassonemail" value="Отправить">
            </td>
        </tr>
    </table>
</form>