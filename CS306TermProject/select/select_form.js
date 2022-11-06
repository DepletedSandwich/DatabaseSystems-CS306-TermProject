function select_hover() {
    const select_elem = document.getElementById("taskOption");
    const anchor = document.getElementById("anchor");
    if(select_elem.value == "sid" && anchor.){
        let form_div = document.createElement("div");
        let form_area = document.createElement("form");
        form_div.appendChild(form_area);
        form_area.id="form_sbmt";
        form_area.action="select.php";
        form_area.method="POST";
        anchor.appendChild(form_div);
        let text_form_lt = document.createElement("input");
        text_form_lt.placeholder = "Greater Than";
        form_area.appendChild(text_form_lt);
        let text_form_gt = document.createElement("input");
        text_form_gt.placeholder = "Lesser Than";
        form_area.appendChild(text_form_gt);
        let smbt_btn = document.createElement("input");
        smbt_btn.type="button";
        smbt_btn.value = "Submit";
        form_area.appendChild(smbt_btn);

    }else if(select_elem.value == "sname"){
        
    }else if(select_elem.value == "slocation"){
        
    }else if(select_elem.value == "scapacity"){
        
    }else{

    }
}