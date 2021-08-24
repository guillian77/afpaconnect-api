
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
            
            app_id = app.getAttribute('id');

            roles.forEach(role => {
                
                let app_field_option =  document.createElement("div");
                
                let app_field_option_label = document.createElement("label");
                app_field_option_label.setAttribute('for', 'app_' + app_id + '_role_' + role['id']);
                app_field_option_label.innerHTML = role.name;

                let el = document.createElement("input");
                el.type = 'checkbox';
                el.className ='form_field';
                el.name = 'app_role_' + app_id + '[]';
                el.id = 'app_' + app_id+ '_role_' + role['id'];
                el.value = role['id'];
                
                app_field_option.append(el);
                app_field_option.append(app_field_option_label);
                app.append(app_field_option);
            
            });
        
        });
    
    
        // Generate Role edit Form
        roles.forEach(role => {
            let role_field = document.createElement("div");
            role_field.className = 'single_field';
            role_field.name = 'name', 'new_role';
            role_field.id = role['id'];

            let role_label = document.createElement('h4');
                role_label.innerHTML = role['name'];
                role_field.append(role_label);
                
            let role_name_field =  document.createElement("div");

            let role_name_label = document.createElement('label');
                role_name_label.setAttribute('for', 'role_name_' + role['id']);
                role_name_label.innerHTML = 'Nom du rôle';

            let role_name_input = document.createElement('input');
                role_name_input.className = 'form__field';
                role_name_input.name = 'role_' + role['id'] +'[]';
                role_name_input.id = 'role_name_' + role['id'] +'[]';
                role_name_input.value = role['name'];

                role_name_field.append(role_name_label);
                role_name_field.append(role_name_input);
                
            let role_tag_field =  document.createElement("div");

            let role_tag_label = document.createElement('label');
                role_tag_label.setAttribute('for', 'role_tag' + role['id']);
                role_tag_label.innerHTML = 'Tag';
                role_tag_field.append(role_tag_label);
                
            let role_tag_input = document.createElement('input');
                role_tag_input.className = 'form__field';
                role_tag_input.name =  'role_' + role['id'] + '[]';
                role_tag_input.id = 'role_tag' + role['id'];
                role_tag_input.value = role['tag']; 
                
                role_tag_field.append(role_tag_input);


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




