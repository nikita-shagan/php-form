const phoneNumberRegex = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;

const openPopupButton = document.querySelector('.main-button');
const closePopupButton = document.querySelector('.popup__close')
const popup = document.querySelector('.popup');
const promoForm = document.querySelector('.promo__form');
const promoFormPhoneInput = document.querySelector('.promo__form-input');

openPopupButton.addEventListener('click', () => {
  popup.classList.add('popup_open');
});

closePopupButton.addEventListener('click', () => {
  popup.classList.remove('popup_open')
})

promoFormPhoneInput.addEventListener('input', (e) => {
  const x = e.target.value.replace('+7 ', '').replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
  const code = !x[2] ? x[1] : '(' + x[1] + ') '
  const restNumber = x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '')
  if (!(code + restNumber)) {
    e.target.value = ''
  } else {
    e.target.value = `+7 ${code}${restNumber}`;
  }
});

promoForm.addEventListener('submit', (e) => {
  if (!phoneNumberRegex.test(promoFormPhoneInput.value)) {
    e.preventDefault()
  }
});
