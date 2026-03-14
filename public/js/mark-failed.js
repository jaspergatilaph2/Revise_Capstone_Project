document.getElementById('inspectionStatus').addEventListener('change', function(){

    this.classList.remove('bg-success','bg-danger','text-white');

    if(this.value === 'passed'){
        this.classList.add('bg-success','text-white');
    }
    else if(this.value === 'failed'){
        this.classList.add('bg-danger','text-white');
    }

});