const handleHTTPErrors = (jqXHR, opts) => {
    opts = opts || {}
    let errors = {
        catched: [],
        exclude: {}
    }
    console.log(jqXHR)

    if (jqXHR.status) {
        if (jqXHR.status == 400) {
            errors.catched.push('Error al conectar con el servidor.')
        } else if (jqXHR.status == 403) {
            errors.catched.push('No posee autorización para realizar ésta acción.')
        } else if (jqXHR.status == 404) {
            errors.catched.push('Recurso buscado no existe o no se encuentra.')
        } else if (jqXHR.status == 405) {
            errors.catched.push('Error al conectar con el servidor.')
        } else if (jqXHR.status == 422) {
            let _errors = jqXHR.responseJSON.errors
            let exclude = opts.excludeKey ? opts.excludeKey : null
            let removeKeyPrefix = opts.removeKeyPrefix ? opts.removeKeyPrefix : ''
            let addKeyPrefix = opts.addKeyPrefix ? opts.addKeyPrefix + '.' : ''

            $.each(_errors, function (_key, _value) {
                if (_key.search(exclude)) {
                    $.each(_value, function (key, value) {
                        errors.catched.push(value)
                    });
                } else {
                    errors.exclude[addKeyPrefix + _key.replace(removeKeyPrefix, '')] = _value.shift()
                }
            });
        } else if (jqXHR.status == 500) {
            errors.catched.push('Error en el servidor')
        }
    } else {
        errors.catched.push('Ha ocurrido un error inesperado.')
    }

    return errors
}

export default handleHTTPErrors
