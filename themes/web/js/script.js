$(document).ready(function(){
    $("#submit-link").click(function(e){
        e.preventDefault();

        $("#registry-form").submit();
    });

    $("#vcs-submit").click(function(e){
       // Submit the VCS form
       e.preventDefault();

       $("#vcs-form").submit();
    });
});

