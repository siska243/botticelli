/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import * as $ from 'jquery'
import DataTable from 'datatables.net-dt';
import 'datatables.net-buttons'

$(document).ready(function(){
    $(".form-check-input").on('change',function(){
    
    const data={
        tache:$(this).attr('data-element')
    }
    fetch("/status/taches",{
        method:"POST",
        body: JSON.stringify(data),
    }).then(e=>{
        window.location.href="/"
    })
    })
})

$(document).ready(function() {
    $.noConflict();
    $('.dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            "pdf",
            "csv"
        ]
    } );
} );
