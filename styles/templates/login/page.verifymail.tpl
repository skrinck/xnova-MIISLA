{block name="title" prepend}{$LNG.verifymail}{/block}
{block name="content"}
    <div class="container" styles="margin-top:80px">
        <div class="row" align="center">
            <div class="panel panel-default" align="center">
                <div class="panel-heading">Inserte el código</div>
            	<div>
					<p>Ponga el código que se le envió a su correo para poder entrar</p>
				</div>
				<form action="index.php?page=veryfymail&id={$id}" method="post">
					<div class="form-group">
						<label for="username">Code</label>
						<input type="text" class="form-control" name="code" id="code" placeholder="codigo">
					</div>
					<div style="text-align: right;">
						<button type="submit" class="btn btn-danger">{$LNG.passwordSubmit}</button>
					</div>
				</form>
        	</div>
        </div>
    </div>
{/block}
