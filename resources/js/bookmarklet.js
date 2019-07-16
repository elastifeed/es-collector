const form = document.createElement('form');
const hiddenField = document.createElement('input');

form.method = 'post';
form.action = '{{url}}';

hiddenField.type = 'hidden';
hiddenField.name = 'url';
hiddenField.value = window.location.href;
form.appendChild(hiddenField);

document.body.appendChild(form);
form.submit();