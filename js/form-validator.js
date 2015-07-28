var glennsFormValidator = {
    myRequiredFields: document.getElementsByClassName('required'),

    checkRequiredFields : function(){
        var myRequiredFields = (this.myRequiredFields.length) ? this.myRequiredFields : 'error';

        if(myRequiredFields != 'error'){
        //loop over all required fields
            for(var i=0; i < myRequiredFields.length; i++){
               //check if value property == ''
                if(!myRequiredFields[i].value){
                 myRequiredFields[i].style.borderColor = '#f00';
                }
            }

        }

},


    init: function(){
        for(var i=0; i < this.myRequiredFields.length; i++){
           this.myRequiredFields[i].addEventListener("blur", function(){
               if(!this.value){
               this.style.borderColor="#f00";
               }else{
               this.style.borderColor="#5cb85c";
               }

              //glennsFormValidator.checkRequiredFields();
           });
        }


    }
};

glennsFormValidator.init();
