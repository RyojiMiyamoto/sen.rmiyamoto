<?php /* Smarty version 2.6.29, created on 2016-06-30 14:58:37
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'message', 'login.tpl', 12, false),)), $this); ?>
<form action="." method="post">
<?php if (count ( $this->_tpl_vars['erroes'] )): ?>
	<ul>
	<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['error']):
?>
		<li><?php echo $this->_tpl_vars['error']; ?>
</li>
	<?php endforeach; endif; unset($_from); ?>
	</ul>
<?php endif; ?>
	<table border="0">
		<tr>
			<td>メールアドレス</td>
			<td><input type="text" name="mailaddress" value="<?php echo $this->_tpl_vars['form']['mailaddress']; ?>
"><?php echo smarty_function_message(array('name' => 'mailaddress'), $this);?>
</td>
		</tr>
		<tr>
			<td>パスワード</td>
			<td><input type="password" name="password" balue=""><?php echo smarty_function_message(array('name' => 'password'), $this);?>
</td>
		</tr>
	</table>
	<p>
	<input type="submit" name="action_login_do" value="ログイン">
	</p>
</form>