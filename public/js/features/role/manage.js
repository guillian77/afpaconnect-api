
/**
 * Get applications and roles from API and fill table with.
 */
 $(document).ready( async ()=> {

    //Get applications
    await get("api/apps",false)
    .then( (apps)=> {
        apps = apps.content;

        // Generate App_Role Edit Form Fields
        for (const [key, value] of Object.entries(apps)) {

            let app_field = document.createElement("div");
            app_field.setAttribute('class','single_field single_field' )
            app_field.id = value['id'];
            $('#app_role_edit').append(app_field);

            let app_label = document.createElement('h4');
            app_label.innerHTML = value['name'];
            app_field.append(app_label);
        }

    })
    .catch((err) => {
        console.log(err)
        $('#error').html("Un problème est survenu lors du chargement des roles").show()
    })

    
    //Get roles
    await get("api/roles",false) 
    .then( (roles)=> {

        roles = roles.content;
        
        // Generate app role edit Fields
        $('#app_role_edit').find('.single_field').each( (i, app) => {
            
            roles.forEach(role => {
                
                let app_field_option =  document.createElement("div");
                
                let app_field_option_label = document.createElement("label");
                app_field_option_label.innerHTML = role.name;

                let el = document.createElement("input");
                el.setAttribute('type','checkbox');
                el.setAttribute('class','form_field');
                el.setAttribute('name','app_role_' +app.getAttribute('id')+ '[]');
                el.value = role['id'];
                
                app_field_option.append(el);
                app_field_option.append(app_field_option_label);
                app.append(app_field_option);
            
            });
        
        });
    
    
        // Generate Role edit Form
        roles.forEach(role => {
            let role_field = document.createElement("div");
            role_field.setAttribute('class','single_field' )
            role_field.setAttribute('name', 'new_role');
            role_field.setAttribute('id', 'new_role');
            role_field.id = role['id'];

            let role_label = document.createElement('h4');
                role_label.innerHTML = role['name'];
                role_field.append(role_label);
                
            let role_name_field =  document.createElement("div");

            let role_name_label = document.createElement('label');
                role_name_label.innerHTML = 'Nom du rôle';

            let role_name_input = document.createElement('input');
                role_name_input.setAttribute('class','form__field');
                role_name_input.setAttribute('name', 'role_' + role['id'] +'[]');
                role_name_input.setAttribute('value', role['name']);

                role_name_field.append(role_name_label);
                role_name_field.append(role_name_input);
                
            let role_tag_field =  document.createElement("div");

            let role_tag_label = document.createElement('label');
                role_tag_label.innerHTML = 'Tag';
                role_tag_field.append(role_tag_label);
                
            let role_tag_input = document.createElement('input');
                role_tag_input.setAttribute('class','form__field');
                role_tag_field.append(role_tag_input);

                role_tag_input.setAttribute('name', 'role_' + role['id'] + '[]');
                role_tag_input.setAttribute('value', role['tag']); 

                role_field.append(role_name_field);
                role_field.append(role_tag_field);

                $('#role_edit').append(role_field);

            });
        
        })

        .catch((err) => {
            console.log(err)
            $('#error').html("Un problème est survenu lors du chargement des rôles").show()
        })

    // Fill App_Role edit Form
    await get("api/apps/roles",false)
        .then( (role_apps)=> {

            role_apps = role_apps.content;

            role_apps.forEach(array_app => {
                $('#app_role_edit').find('.single_field').each( (i, app) => {
                    array_app['app_roles'].forEach(role_app => {
                        if(app.id == role_app['pivot']['app_id'] ) {
                                $('#app_role_edit #' + app.id ).find('input[value="' + role_app.id + '"]').prop('checked',true);
                        }
                    });
                });
            });

        })
        .catch((err) => {
            console.log(err)
            $('#error').html("Un problème est survenu lors du chargement des roles").show()
    })
})




