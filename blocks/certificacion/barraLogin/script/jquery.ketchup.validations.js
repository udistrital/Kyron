jQuery.ketchup

.validation('required', 'Campo requerido.', function(form, el, value) {
  var type = el.attr('type').toLowerCase();
  
  if(type == 'checkbox' || type == 'radio') {
    return (el.attr('checked') == true);
  } else {
    return (value.length != 0);
  }
})

.validation('minlength', 'Debe tener mínimo {arg1} caracteres.', function(form, el, value, min) {
  return (value.length >= +min);
})

.validation('maxlength', 'Debe tener un tamaño máximo de {arg1}.', function(form, el, value, max) {
  return (value.length <= +max);
})

.validation('rangelength', 'Debe tener una longitud entre {arg1} y {arg2}.', function(form, el, value, min, max) {
  return (value.length >= min && value.length <= max);
})

.validation('min', 'Debe ser mayor o igual a {arg1}.', function(form, el, value, min) {
  return (this.isNumber(value) && +value >= +min);
})

.validation('max', 'No puede ser mayor a {arg1}.', function(form, el, value, max) {
  return (this.isNumber(value) && +value <= +max);
})

.validation('range', 'Debe estar entre {arg1} y {arg2}.', function(form, el, value, min, max) {
  return (this.isNumber(value) && +value >= +min && +value <= +max);
})

.validation('number', 'Debe ser un número.', function(form, el, value) {
  return this.isNumber(value);
})

.validation('digits', 'Deben ser dígitos.', function(form, el, value) {
  return /^\d+$/.test(value);
})

.validation('email', 'Debe ser un correo válido.', function(form, el, value) {
  return this.isEmail(value);
})

.validation('url', 'Debe ser una URL válida.', function(form, el, value) {
  return this.isUrl(value);
})

.validation('username', 'Debe ser un nombre de usuario válido.', function(form, el, value) {
  return this.isUsername(value);
})

.validation('match', 'Debe ser {arg1}.', function(form, el, value, word) {
  return (el.val() == word);
})

.validation('contain', 'Debe contener {arg1}', function(form, el, value, word) {
  return this.contains(value, word);
})

.validation('date', 'Debe ser una fecha válida.', function(form, el, value) {
  return this.isDate(value);
})

.validation('minselect', 'Seleccione por lo menos {arg1} checkboxes.', function(form, el, value, min) {
  return (min <= this.inputsWithName(form, el).filter(':checked').length);
}, function(form, el) {
  this.bindBrothers(form, el);
})

.validation('maxselect', 'No puede seleccionar más de {arg1} checkboxes.', function(form, el, value, max) {
  return (max >= this.inputsWithName(form, el).filter(':checked').length);
}, function(form, el) {
  this.bindBrothers(form, el);
})

.validation('rangeselect', 'Debe seleccionar entre {arg1} y {arg2} checkboxes.', function(form, el, value, min, max) {
  var checked = this.inputsWithName(form, el).filter(':checked').length;
  
  return (min <= checked && max >= checked);
}, function(form, el) {
  this.bindBrothers(form, el);
});