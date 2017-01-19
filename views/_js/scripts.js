$(document).ready(function(){
	mask9digito('input[type=tel]');

	$('form').submit(function(){
		var erros = 0;
        $(this).find('.has-error span').html('').parent().removeClass('has-error');

        $(this).find('[required]').each(function(){
            if(!$(this).val()){
                $(this).parent().addClass('has-error').find('span').html('campo obrigatório');
                erros++;
            } else if($(this).attr('type')=='email' && !validateEmail($(this).val())){
                $(this).parent().addClass('has-error').find('span').html('email inválido');
                erros++;
            }
        });

        if(erros==0){
            return true;
        }

        return false;
	});
});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}