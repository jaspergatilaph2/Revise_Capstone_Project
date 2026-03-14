document.getElementById('severitySelect').addEventListener('change', function() {

    let severity = this.value;

    // reset classes
    this.classList.remove('bg-success','bg-warning','bg-danger','bg-dark','text-white');

    if(severity === 'low'){
        this.classList.add('bg-success','text-white');
    }
    else if(severity === 'moderate'){
        this.classList.add('bg-warning');
    }
    else if(severity === 'high'){
        this.classList.add('bg-danger','text-white');
    }
    else if(severity === 'critical'){
        this.classList.add('bg-dark','text-white');
    }

});