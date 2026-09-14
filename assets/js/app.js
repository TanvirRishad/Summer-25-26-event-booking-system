document.addEventListener('DOMContentLoaded',function(){
    document.querySelectorAll('form').forEach(function(form){
        form.addEventListener('submit',function(e){
            const password=form.querySelector('input[name="password"]');
            if(password && password.value.length < 6){
                e.preventDefault();
                alert('Password must be at least 6 characters.');
            }
        });
    });
});
