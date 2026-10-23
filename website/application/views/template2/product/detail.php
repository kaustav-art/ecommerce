<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$bazaro = isset($tpl_assets) ? rtrim($tpl_assets, '/') . '/' : base_url('assets/templates/bazaro/');
?>

   <!-- Question Modal (#exampleModalToggle4) -->
   <div class="aq-login-modal-style">
      <div class="modal fade" id="exampleModalToggle4" role="dialog" aria-hidden="true" aria-labelledby="exampleModalToggle4" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               <div class="aq-login-wrapper">
                  <div class="aq-login-top mb-30">
                     <h3 class="aq-login-title">Ask Question</h3>
                  </div>
                  <div class="aq-login-option">
                     <div class="aq-login-input-wrapper">
                        <div class="aq-login-input-box">
                           <div class="aq-login-input-title">
                              <label class="aq-form-label">Your Question <span>*</span></label>
                           </div>
                           <div class="aq-login-input">
                              <textarea class="aq-form-input" placeholder="Your Question"></textarea>
                           </div>
                        </div>
                     </div>
                     <div class="aq-login-bottom-wrap text-center mb-20">
                        <button type="button" class="aq-login-btn w-100 mb-10" data-bs-dismiss="modal" onclick="if(typeof showEltToast==='function')showEltToast('Your question has been submitted!');">Submit</button>
                        <button type="button" class="aq-login-btn btn-transparent w-100 mb-10" data-bs-dismiss="modal" aria-label="Close">Back</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Return Policy Modal (#exampleModalToggle5) -->
   <div class="aq-return-modal-style">
      <div class="modal fade" id="exampleModalToggle5" role="dialog" aria-hidden="true" aria-labelledby="exampleModalToggle5" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               <div class="product-details-tab-item">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="product-details-policy">
                           <h4 class="product-details-policy-title">Shipping policy</h4>
                           <p>
                              We strive to provide fast and reliable shipping to our customers. Here's everything you need to know about our shipping process:
                           </p>
                           <ul class="product-details-policy-list mb-30">
                              <li>Dispatch: Within 24 Hours</li>
                              <li>Cash on delivery might be available</li>
                              <li>Easy 30 days returns and exchanges</li>
                           </ul>
                           <h4 class="product-details-policy-title">Returns policy</h4>
                           <p>
                              We want you to be completely satisfied with your purchase from our website. If for any reason you are not entirely happy with your order, we're here to help. <br>
                           </p>
                           <ul class="product-details-policy-list mb-30">
                              <li>All orders shipped with UPS Express.</li>
                              <li>Always free shipping for orders over US $250.</li>
                              <li>All orders are shipped with a UPS tracking number.</li>
                           </ul>
                           <h4 class="product-details-policy-title">Help</h4>
                           <p>Give us a shout if you have any other questions and/or concerns.</p>
                           <ul class="product-details-policy-info mb-30">
                              <li><a href="tel:0123456789">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                 <path d="M0.770285 10.7567L4.53911 9.06793L4.54951 9.06313C4.74517 8.97944 4.9586 8.94586 5.1705 8.96541C5.3824 8.98497 5.58608 9.05705 5.76312 9.17513C5.78396 9.18889 5.804 9.20385 5.82312 9.21993L7.77033 10.8799C9.00394 10.2807 10.2776 9.01673 10.8768 7.79911L9.21434 5.82229C9.19834 5.80229 9.18314 5.78229 9.16874 5.76069C9.0532 5.58413 8.9831 5.38175 8.96467 5.17155C8.94625 4.96135 8.98008 4.74985 9.06314 4.55588V4.54628L10.7568 0.771045C10.8666 0.517655 11.0554 0.306573 11.295 0.169311C11.5346 0.0320479 11.8122 -0.0240334 12.0864 0.0094382C13.1704 0.152085 14.1654 0.684459 14.8856 1.50713C15.6058 2.3298 16.002 3.3865 16 4.47988C16 10.8319 10.832 16 4.47991 16C3.38654 16.002 2.32983 15.6058 1.50717 14.8856C0.684499 14.1654 0.152126 13.1704 0.00947881 12.0864C-0.0240543 11.8123 0.0319102 11.5348 0.169022 11.2952C0.306134 11.0556 0.517044 10.8667 0.770285 10.7567ZM4.47991 14.72C7.19484 14.717 9.79772 13.6372 11.7175 11.7174C13.6372 9.7977 14.717 7.19481 14.72 4.47988C14.723 3.69867 14.4415 2.94306 13.9282 2.35419C13.4148 1.76531 12.7047 1.38342 11.9304 1.27985C11.9307 1.28304 11.9307 1.28626 11.9304 1.28945L10.2504 5.04949L11.904 7.02871C11.9207 7.04802 11.936 7.06861 11.9496 7.09031C12.07 7.27504 12.1406 7.48775 12.1546 7.7078C12.1686 7.92786 12.1255 8.1478 12.0296 8.34632C11.3048 9.82873 9.81115 11.3111 8.31274 12.0352C8.11276 12.1302 7.89155 12.1718 7.6707 12.1558C7.44985 12.1398 7.23693 12.0668 7.05273 11.944C7.03219 11.9301 7.01243 11.9152 6.99353 11.8992L5.04872 10.2399L1.28869 11.924C1.28869 11.924 1.28229 11.924 1.27989 11.924C1.3822 12.6994 1.76351 13.411 2.35249 13.9256C2.94148 14.4402 3.69778 14.7226 4.47991 14.72Z" fill="#343330"/>
                                 </svg> (303) 555-0105
                              </a></li>
                              <li><a href="mailto:Global@store.com">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                                 <path d="M15.7262 5.10495L8.34154 0.105091C8.24041 0.0365682 8.12157 0 8 0C7.87843 0 7.75959 0.0365682 7.65846 0.105091L0.273846 5.10495C0.189547 5.16208 0.120442 5.23946 0.0726691 5.33022C0.0248963 5.42099 -6.56915e-05 5.52233 1.29834e-07 5.62525V13.75C1.29834e-07 14.0815 0.12967 14.3995 0.360484 14.6339C0.591298 14.8683 0.904349 15 1.23077 15H14.7692C15.0957 15 15.4087 14.8683 15.6395 14.6339C15.8703 14.3995 16 14.0815 16 13.75V5.62525C16.0001 5.52233 15.9751 5.42099 15.9273 5.33022C15.8796 5.23946 15.8105 5.16208 15.7262 5.10495ZM8 1.37615L14.3008 5.64244L9.14692 9.37515H6.85462L1.70077 5.64244L8 1.37615ZM1.23077 13.75V6.8385L6.3 10.5103C6.40437 10.586 6.52943 10.6267 6.65769 10.6267H9.34231C9.47057 10.6267 9.59563 10.586 9.7 10.5103L14.7692 6.8385V13.75H1.23077Z" fill="#343330"/>
                                 </svg>Global@store.com
                              </a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Share Modal (#exampleModalToggle6) -->
   <div class="aq-share-modal-style">
      <div class="modal fade" id="exampleModalToggle6" role="dialog" aria-hidden="true" aria-labelledby="exampleModalToggle6" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               <div class="aq-share-wrapper">
                  <div class="aq-share-top mb-15">
                     <h3 class="aq-login-title">Share link</h3>
                  </div>
                  <div class="aq-share-container">
                     <div class="aq-share-link-wrapper">
                        <input type="text" class="aq-share-input" value="https://html.bajaro.shop/shofy-prv..." readonly>
                        <button type="button" class="aq-share-copy-btn">
                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                              <path d="M3.69994 12.7001H2.79996C2.32258 12.7001 1.86476 12.5104 1.5272 12.1728C1.18964 11.8353 1 11.3774 1 10.9001V2.80001C1 2.32262 1.18964 1.86478 1.5272 1.52721C1.86476 1.18964 2.32258 1 2.79996 1H10.8998C11.3772 1 11.835 1.18964 12.1726 1.52721C12.5101 1.86478 12.6998 2.32262 12.6998 2.80001V3.70001M9.10074 7.30005H17.2006C18.1947 7.30005 19.0005 8.10594 19.0005 9.10006V17.2001C19.0005 18.1942 18.1947 19.0001 17.2006 19.0001H9.10074C8.10665 19.0001 7.30078 18.1942 7.30078 17.2001V9.10006C7.30078 8.10594 8.10665 7.30005 9.10074 7.30005Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>
                        </button>
                     </div>
                     <div class="aq-share-socials">
                        <a href="#" class="aq-share-social-item">
                           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                              <path d="M8.775 0C7.03947 0 5.34292 0.514645 3.89987 1.47885C2.45683 2.44306 1.33212 3.81353 0.667961 5.41695C0.00380206 7.02037 -0.169972 8.78473 0.168613 10.4869C0.507198 12.1891 1.34294 13.7527 2.57014 14.9799C3.79735 16.2071 5.3609 17.0428 7.06309 17.3814C8.76527 17.72 10.5296 17.5462 12.133 16.882C13.7365 16.2179 15.1069 15.0932 16.0711 13.6501C17.0354 12.2071 17.55 10.5105 17.55 8.775C17.5475 6.44848 16.6222 4.21795 14.9772 2.57285C13.3321 0.927752 11.1015 0.00245685 8.775 0ZM9.45 16.1688V10.8H11.475C11.654 10.8 11.8257 10.7289 11.9523 10.6023C12.0789 10.4757 12.15 10.304 12.15 10.125C12.15 9.94598 12.0789 9.77429 11.9523 9.6477C11.8257 9.52111 11.654 9.45 11.475 9.45H9.45V7.425C9.45 7.06696 9.59224 6.72358 9.84541 6.47041C10.0986 6.21723 10.442 6.075 10.8 6.075H12.15C12.329 6.075 12.5007 6.00388 12.6273 5.8773C12.7539 5.75071 12.825 5.57902 12.825 5.4C12.825 5.22098 12.7539 5.04929 12.6273 4.9227C12.5007 4.79612 12.329 4.725 12.15 4.725H10.8C10.0839 4.725 9.39716 5.00946 8.89082 5.51581C8.38447 6.02216 8.1 6.70891 8.1 7.425V9.45H6.075C5.89598 9.45 5.72429 9.52111 5.59771 9.6477C5.47112 9.77429 5.4 9.94598 5.4 10.125C5.4 10.304 5.47112 10.4757 5.59771 10.6023C5.72429 10.7289 5.89598 10.8 6.075 10.8H8.1V16.1688C6.19717 15.9951 4.43455 15.0945 3.17878 13.6544C1.923 12.2142 1.27075 10.3454 1.35769 8.43668C1.44464 6.52791 2.26408 4.72614 3.64557 3.40614C5.02707 2.08614 6.86426 1.34953 8.775 1.34953C10.6857 1.34953 12.5229 2.08614 13.9044 3.40614C15.2859 4.72614 16.1054 6.52791 16.1923 8.43668C16.2793 10.3454 15.627 12.2142 14.3712 13.6544C13.1155 15.0945 11.3528 15.9951 9.45 16.1688Z" fill="currentColor"/>
                           </svg>
                        </a>
                        <a href="#" class="aq-share-social-item">
                           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                              <path d="M15.1002 14.8859L10.6987 7.96852L15.0419 3.19078C15.1401 3.08006 15.1907 2.93508 15.1828 2.78727C15.1748 2.63947 15.1089 2.50076 14.9994 2.40121C14.8899 2.30166 14.7455 2.2493 14.5976 2.25548C14.4497 2.26166 14.3102 2.32588 14.2094 2.43422L10.0722 6.98484L7.22524 2.51086C7.17447 2.43095 7.10436 2.36515 7.02139 2.31955C6.93843 2.27395 6.8453 2.25003 6.75063 2.25H3.37563C3.27477 2.24995 3.17576 2.27702 3.08896 2.32837C3.00215 2.37972 2.93075 2.45347 2.88223 2.54188C2.83371 2.6303 2.80985 2.73014 2.81316 2.83094C2.81646 2.93174 2.84681 3.0298 2.90102 3.11484L7.30258 10.0315L2.95938 14.8127C2.90866 14.8672 2.86926 14.9312 2.84346 15.001C2.81766 15.0709 2.80598 15.1451 2.80908 15.2195C2.81219 15.2939 2.83003 15.3669 2.86156 15.4343C2.8931 15.5017 2.9377 15.5622 2.99279 15.6123C3.04787 15.6623 3.11235 15.701 3.18247 15.7259C3.2526 15.7509 3.32698 15.7617 3.40131 15.7577C3.47564 15.7537 3.54844 15.735 3.61548 15.7026C3.68252 15.6703 3.74248 15.625 3.79188 15.5693L7.92907 11.0187L10.776 15.4927C10.8272 15.5719 10.8975 15.637 10.9804 15.682C11.0634 15.727 11.1563 15.7503 11.2506 15.75H14.6256C14.7264 15.75 14.8253 15.7229 14.912 15.6716C14.9987 15.6202 15.07 15.5466 15.1185 15.4583C15.167 15.37 15.1909 15.2703 15.1877 15.1696C15.1845 15.0689 15.1543 14.9709 15.1002 14.8859ZM11.5593 14.625L4.40008 3.375H6.43915L13.6012 14.625H11.5593Z" fill="currentColor"/>
                           </svg>
                        </a>
                        <a href="#" class="aq-share-social-item">
                           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                              <path d="M9 5.625C8.33249 5.625 7.67997 5.82294 7.12495 6.19379C6.56993 6.56464 6.13735 7.09174 5.88191 7.70844C5.62646 8.32514 5.55962 9.00374 5.68985 9.65843C5.82008 10.3131 6.14151 10.9145 6.61351 11.3865C7.08552 11.8585 7.68688 12.1799 8.34157 12.3102C8.99626 12.4404 9.67486 12.3735 10.2916 12.1181C10.9083 11.8626 11.4354 11.4301 11.8062 10.875C12.1771 10.32 12.375 9.66751 12.375 9C12.3741 8.10518 12.0182 7.24728 11.3855 6.61454C10.7527 5.98181 9.89482 5.62593 9 5.625ZM9 11.25C8.55499 11.25 8.11998 11.118 7.74997 10.8708C7.37996 10.6236 7.09157 10.2722 6.92127 9.86104C6.75097 9.4499 6.70642 8.9975 6.79323 8.56105C6.88005 8.12459 7.09434 7.72368 7.40901 7.40901C7.72368 7.09434 8.12459 6.88005 8.56105 6.79323C8.9975 6.70642 9.4499 6.75097 9.86104 6.92127C10.2722 7.09157 10.6236 7.37996 10.8708 7.74997C11.118 8.11998 11.25 8.55499 11.25 9C11.25 9.59674 11.0129 10.169 10.591 10.591C10.169 11.0129 9.59674 11.25 9 11.25ZM12.375 1.6875H5.625C4.58105 1.68862 3.58018 2.10382 2.842 2.842C2.10382 3.58018 1.68862 4.58105 1.6875 5.625V12.375C1.68862 13.4189 2.10382 14.4198 2.842 15.158C3.58018 15.8962 4.58105 16.3114 5.625 16.3125H12.375C13.4189 16.3114 14.4198 15.8962 15.158 15.158C15.8962 14.4198 16.3114 13.4189 16.3125 12.375V5.625C16.3114 4.58105 15.8962 3.58018 15.158 2.842C14.4198 2.10382 13.4189 1.68862 12.375 1.6875ZM15.1875 12.375C15.1875 13.1209 14.8912 13.8363 14.3637 14.3637C13.8363 14.8912 13.1209 15.1875 12.375 15.1875H5.625C4.87908 15.1875 4.16371 14.8912 3.63626 14.3637C3.10882 13.8363 2.8125 13.1209 2.8125 12.375V5.625C2.8125 4.87908 3.10882 4.16371 3.63626 3.63626C4.16371 3.10882 4.87908 2.8125 5.625 2.8125H12.375C13.1209 2.8125 13.8363 3.10882 14.3637 3.63626C14.8912 4.16371 15.1875 4.87908 15.1875 5.625V12.375ZM13.5 5.34375C13.5 5.51063 13.4505 5.67376 13.3578 5.81251C13.2651 5.95127 13.1333 6.05941 12.9791 6.12327C12.825 6.18713 12.6553 6.20384 12.4916 6.17129C12.328 6.13873 12.1776 6.05837 12.0596 5.94037C11.9416 5.82237 11.8613 5.67203 11.8287 5.50836C11.7962 5.34469 11.8129 5.17504 11.8767 5.02086C11.9406 4.86669 12.0487 4.73491 12.1875 4.6422C12.3262 4.54948 12.4894 4.5 12.6562 4.5C12.88 4.5 13.0946 4.58889 13.2529 4.74713C13.4111 4.90536 13.5 5.11997 13.5 5.34375Z" fill="currentColor"/>
                           </svg>
                        </a>
                        <a href="#" class="aq-share-social-item">
                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                              <path d="M17.3254 8.66261C17.3254 10.4083 16.7144 12.0039 15.606 13.1571C14.5712 14.2314 13.1682 14.8501 11.7566 14.8501C10.3737 14.8501 9.45025 14.3969 8.86167 13.922L8.0279 17.4659C7.99613 17.6018 7.91932 17.7231 7.80993 17.8098C7.70054 17.8966 7.56502 17.9439 7.42539 17.9439C7.3775 17.9438 7.32976 17.9384 7.28308 17.9276C7.20367 17.9094 7.12864 17.8757 7.06229 17.8284C6.99595 17.7811 6.93961 17.7211 6.89649 17.652C6.85337 17.5829 6.82433 17.5059 6.81104 17.4255C6.79774 17.3451 6.80045 17.2629 6.81902 17.1836L9.29402 6.66482C9.33156 6.50502 9.43103 6.36669 9.57057 6.28024C9.71011 6.19379 9.87827 6.16631 10.0381 6.20385C10.1979 6.24139 10.3362 6.34087 10.4226 6.4804C10.5091 6.61994 10.5366 6.7881 10.499 6.9479L9.19192 12.5012C9.43633 12.8392 10.1556 13.6126 11.7566 13.6126C13.8859 13.6126 16.0879 11.761 16.0879 8.66261C16.0876 7.80863 15.8908 6.96616 15.5129 6.20036C15.135 5.43456 14.586 4.76593 13.9084 4.24618C13.2308 3.72643 12.4427 3.36949 11.6051 3.20295C10.7676 3.03641 9.90289 3.06473 9.07801 3.28573C8.25312 3.50673 7.49011 3.91449 6.84798 4.47747C6.20584 5.04045 5.70179 5.74358 5.3748 6.53247C5.04781 7.32137 4.90663 8.1749 4.96219 9.02708C5.01775 9.87925 5.26855 10.7072 5.69521 11.447C5.77218 11.5887 5.79076 11.7549 5.747 11.9101C5.70324 12.0654 5.6006 12.1974 5.46094 12.278C5.32128 12.3587 5.15565 12.3817 4.99932 12.342C4.84299 12.3023 4.70832 12.2032 4.624 12.0657C4.10226 11.1616 3.79548 10.1496 3.72739 9.10791C3.65929 8.06626 3.83171 7.0229 4.23129 6.05853C4.63088 5.09416 5.24694 4.23463 6.03181 3.54641C6.81668 2.85818 7.74934 2.35972 8.75765 2.08956C9.76596 1.8194 10.8229 1.78479 11.8467 1.9884C12.8706 2.19201 13.8338 2.62839 14.662 3.26379C15.4903 3.89919 16.1612 4.71657 16.6231 5.65273C17.0849 6.58889 17.3252 7.61873 17.3254 8.66261Z" fill="currentColor"/>
                           </svg>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Size Chart Modal (#exampleModalToggle7) -->
   <div class="aq-size-modal-style">
      <div class="modal fade" id="exampleModalToggle7" role="dialog" aria-hidden="true" aria-labelledby="exampleModalToggle7" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               <div class="aq-size-modal-wrap">
                  <img src="<?= $bazaro; ?>img/size-chart/woman-size.jpg" alt="">
               </div>
            </div>
         </div>
      </div>
   </div>

   <main>

      <!-- breadcrumb area start -->
      <div class="pd-breadcrumb-area">
         <div class="container">
            <div class="row">
               <div class="col-xl-8">
                  <div class="pd-breadcrumb-content">
                     <div class="pd-breadcrumb-list">
                        <span><a href="<?= site_url('home?preview_tpl=electronics'); ?>">home</a></span>
                        <span>/</span>
                        <span><a href="<?= site_url('shop?preview_tpl=electronics'); ?>">shop</a></span>
                        <span>/</span>
                        <span><a href="#">Osette backpack Bags</a></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- product details area start -->
      <div class="aq-product-details-thumbnails-style pb-120">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 order-lg-1 order-2">
                  <div class="product-details-slider-wrap">
                     <div class="product-slider-main-wrap p-relative mb-10">
                        <div class="product-slider-main slider-for p-relative">
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-1.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-1.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-2.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-2.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-3.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-3.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-4.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-4.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-1.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-1.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-2.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-2.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-3.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-3.jpg" alt="">
                              </a>
                           </div>
                           <div class="product-slider-for-img">
                              <a class="popup-image" href="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-4.jpg">
                                 <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-4.jpg" alt="">
                              </a>
                           </div>
                        </div>
                        <div class="product-slider-arrow"></div>
                     </div>
                     <div class="product-slider-nav-2 slider-nav-2">
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-1.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-2.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-3.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-4.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-1.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-2.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-3.jpg" alt="">
                        </div>
                        <div class="product-slider-nav-img">
                           <img src="<?= $bazaro; ?>img/fashion-1/product/product-10/thumb-4.jpg" alt="">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 order-lg-2 order-1">
                  <div class="aq-product-details-wrap pt-25 ml-30">

                     <!-- product info  -->
                     <div class="aq-product-details-category"><span>Girls Clothes</span></div>
                     <h3 class="aq-product-details-title mb-10">Osette backpack Bags</h3>

                     <!-- inventory details  -->
                     <div class="tp-product-details-inventory">
                        <div class="aq-product-details-rating-wrapper d-flex align-items-center">
                           <div class="aq-product-details-rating-box d-flex align-items-center mb-10">
                              <div class="aq-product-details-rating">
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                       <path d="M6.6574 0L8.50892 4.4516L13.3148 4.83688L9.65322 7.9734L10.7719 12.6631L6.6574 10.15L2.5429 12.6631L3.66157 7.9734L0 4.83688L4.80587 4.4516L6.6574 0Z" fill="currentcolor"/>
                                    </svg>
                                 </span>
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                       <path d="M6.6574 0L8.50892 4.4516L13.3148 4.83688L9.65322 7.9734L10.7719 12.6631L6.6574 10.15L2.5429 12.6631L3.66157 7.9734L0 4.83688L4.80587 4.4516L6.6574 0Z" fill="currentcolor"/>
                                    </svg>
                                 </span>
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                       <path d="M6.6574 0L8.50892 4.4516L13.3148 4.83688L9.65322 7.9734L10.7719 12.6631L6.6574 10.15L2.5429 12.6631L3.66157 7.9734L0 4.83688L4.80587 4.4516L6.6574 0Z" fill="currentcolor"/>
                                    </svg>
                                 </span>
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                       <path d="M6.6574 0L8.50892 4.4516L13.3148 4.83688L9.65322 7.9734L10.7719 12.6631L6.6574 10.15L2.5429 12.6631L3.66157 7.9734L0 4.83688L4.80587 4.4516L6.6574 0Z" fill="currentcolor"/>
                                    </svg>
                                 </span>
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                       <path d="M6.6574 0L8.50892 4.4516L13.3148 4.83688L9.65322 7.9734L10.7719 12.6631L6.6574 10.15L2.5429 12.6631L3.66157 7.9734L0 4.83688L4.80587 4.4516L6.6574 0Z" fill="currentcolor"/>
                                    </svg>
                                 </span>
                              </div>
                              <div class="aq-product-details-reviews">
                                 <span>( 1 review )</span>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- price info  -->
                     <div class="aq-product-details-price-wrap mb-20">
                        <ins><span class="aq-product-details-price new-price">$160.00</span></ins>
                     </div>

                     <div class="aq-product-color aq-product-color-large mb-25">
                        <h4 class="aq-product-details-title-sm mb-15"><label>Color:</label> Chestnut</h4>
                        <ul>
                           <li class="aq-product-color-item aq-tooltip-top aq-color-swatch active">
                              <span class="aq-tooltip-item">Brown</span>
                              <span class="aq-product-color-value" data-bg-color="#8D694A" style="background-color: rgb(141, 105, 74);"></span>
                           </li>
                           <li class="aq-product-color-item aq-tooltip-top aq-color-swatch">
                              <span class="aq-tooltip-item">Iridium</span>
                              <span class="aq-product-color-value" data-bg-color="#3A3F32" style="background-color: rgb(58, 63, 50);"></span>
                           </li>
                           <li class="aq-product-color-item aq-tooltip-top aq-color-swatch">
                              <span class="aq-tooltip-item">Darb</span>
                              <span class="aq-product-color-value" data-bg-color="#7B7C4C" style="background-color: rgb(123, 124, 76);"></span>
                           </li>
                        </ul>
                     </div>

                     <!-- product-size -->
                     <div class="aq-product-details-size mb-30">
                        <div class="aq-product-details-size d-flex justify-content-between">
                           <h4 class="aq-product-details-title-sm mb-15">Laptop Ram</h4>
                           <button type="button" class="product-details-size-guide d-flex align-items-center mb-15" data-bs-target="#exampleModalToggle7" data-bs-toggle="modal">
                              <i>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="21" height="13" viewBox="0 0 21 13" fill="none">
                                    <path d="M1.75 12.25C1.35 12.25 1 12.1 0.7 11.8C0.4 11.5 0.25 11.15 0.25 10.75V1.75C0.25 1.36667 0.4 1.02083 0.7 0.7125C1 0.404167 1.35 0.25 1.75 0.25H18.75C19.15 0.25 19.5 0.404167 19.8 0.7125C20.1 1.02083 20.25 1.36667 20.25 1.75V10.75C20.25 11.15 20.1 11.5 19.8 11.8C19.5 12.1 19.15 12.25 18.75 12.25H1.75ZM1.75 10.75H18.75V1.75H15.5V6.25H14V1.75H11V6.25H9.5V1.75H6.5V6.25H5V1.75H1.75V10.75Z" fill="#DA3F3F" stroke="white" stroke-width="0.5"/>
                                 </svg>
                              </i>
                              Size Guide
                           </button>
                        </div>
                        <div class="aq-product-details-color-select">
                           <div class="aqf-bundle-select aq-select">
                              <select>
                                 <option>32GB</option>
                                 <option>64GB</option>
                                 <option>128GB</option>
                                 <option>256GB</option>
                              </select>
                           </div>
                        </div>
                     </div>

                     <!-- product-variation -->
                     <div class="aq-product-color aq-product-color-large mb-30">
                        <h4 class="aq-product-details-title-sm mb-15">Laptop storage</h4>
                        <div class="aq-product-details-radio-select">
                           <label class="aq-radio-item">
                              <input type="radio" name="storage">
                              <span class="aq-radio"></span>
                              <span class="aq-label">500GB</span>
                           </label>

                           <label class="aq-radio-item">
                              <input type="radio" name="storage" checked>
                              <span class="aq-radio"></span>
                              <span class="aq-label">1TB</span>
                           </label>

                           <label class="aq-radio-item">
                              <input type="radio" name="storage">
                              <span class="aq-radio"></span>
                              <span class="aq-label">2TB</span>
                           </label>
                        </div>

                     </div>

                     <!-- product-action -->
                     <div class="aq-product-details-action-wrapper mb-25">
                        <div class="aq-product-details-action-item-wrapper d-sm-flex align-items-center">
                           <div class="aq-product-details-quantity">
                              <div class="aq-product-quantity mb-10 mr-10">
                                 <span class="aq-cart-minus">
                                    <svg width="11" height="2" viewBox="0 0 11 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M1 1H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                 </span>
                                 <input class="aq-cart-input" type="text" value="1">
                                 <span class="aq-cart-plus">
                                    <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M1 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                       <path d="M5.5 10.5V1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                 </span>
                              </div>
                           </div>
                           <div class="aq-product-details-add-to-cart d-flex align-items-center mb-10 w-100">
                              <div class="aq-product-details-add-to-cart-btn w-100">
                                 <button type="button" class="aq-btn-black btn-square w-100" onclick="bazaroAddToCart(1, 1, true)">Add To Cart</button>
                              </div>
                              <button type="button" class="aq-product-action-btn action-btn-2 aq-wishlist-btn aq-tooltip-top" onclick="bazaroToggleWishlist(1, this)">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none">
                                    <path d="M14.7197 1.52347C12.5744 0.244089 10.7019 0.759666 9.57712 1.58092C9.11591 1.91766 8.88531 2.08602 8.74963 2.08602C8.61396 2.08602 8.38336 1.91766 7.92215 1.58092C6.79733 0.759666 4.9249 0.244089 2.77958 1.52347C-0.0359114 3.20253 -0.67299 8.7418 5.82126 13.4151C7.05821 14.3052 7.67668 14.7502 8.74963 14.7502C9.82258 14.7502 10.4411 14.3052 11.678 13.4151C18.1723 8.7418 17.5352 3.20253 14.7197 1.52347Z" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"/>
                                 </svg>                                                                               
                                 <span class="aq-tooltip-item">Wishlist</span>
                              </button>
                              <button type="button" class="aq-product-action-btn action-btn-2 aq-compare-btn aq-tooltip-top">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                                    <path d="M11.6755 5.91828L14.2612 3.33412M14.2612 3.33412L11.6755 0.75M14.2612 3.33412L1.74999 3.33374M3.33562 8.07153L0.75 10.6557L3.33562 13.2398M13.7724 10.75H1.26122" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>                                                                          
                                 <span class="aq-tooltip-item">Compare</span>
                              </button>
                           </div>
                        </div>
                        <div class="aq-product-details-buy-now-btn">
                           <button type="button" class="aq-btn-black btn-red-bg btn-square w-100" onclick="bazaroAddToCart(1, 1, false); window.location.href='<?= site_url('checkout?preview_tpl=electronics'); ?>';">Buy Now</button>
                        </div>
                     </div>

                     <!-- product-action -->
                     <div class="aq-product-details-action-sm">
                        <button type="button" class="aq-product-details-action-sm-btn" data-bs-target="#exampleModalToggle5" data-bs-toggle="modal">
                           <svg xmlns="http://www.w3.org/2000/svg" width="19" height="16" viewBox="0 0 19 16" fill="none">
                              <path d="M18.1509 6.77558H18.8009C18.8009 6.668 18.7742 6.5621 18.7232 6.46738L18.1509 6.77558ZM9.77434 0.778871L9.9752 0.160685V0.160684L9.77434 0.778871ZM11.4597 2.46428L10.8416 2.66514V2.66514L11.4597 2.46428ZM11.6739 5.56632L11.0557 5.76718V5.76718L11.6739 5.56632ZM12.7975 6.68992L12.5966 7.30811V7.30811L12.7975 6.68992ZM3.24311 13.5259C3.60165 13.5437 3.90679 13.2676 3.92466 12.909C3.94254 12.5505 3.66637 12.2453 3.30783 12.2275L3.27547 12.8767L3.24311 13.5259ZM1.29111 12.26L0.831495 12.7197H0.831495L1.29111 12.26ZM6.77553 12.2508C6.41654 12.2508 6.12555 12.5418 6.12558 12.9008C6.12561 13.2598 6.41664 13.5508 6.77563 13.5508L6.77558 12.9008L6.77553 12.2508ZM15.4935 12.2275C15.1349 12.2453 14.8588 12.5505 14.8767 12.909C14.8945 13.2676 15.1997 13.5437 15.5582 13.5259L15.5258 12.8767L15.4935 12.2275ZM0.650391 0.000390649C0.291406 0.000390649 0.000390649 0.291406 0.000390649 0.650391C0.000390649 1.00938 0.291406 1.30039 0.650391 1.30039V0.650391V0.000390649ZM1.32369 10.2433C1.30582 9.88478 1.00068 9.60862 0.642138 9.62649C0.283598 9.64436 0.00743204 9.9495 0.0253041 10.308L0.674498 10.2757L1.32369 10.2433ZM0.650569 3.5004C0.291584 3.5004 0.000568688 3.79142 0.000568688 4.1504C0.000568688 4.50939 0.291584 4.8004 0.650569 4.8004V4.1504V3.5004ZM5.90073 4.8004C6.25971 4.8004 6.55073 4.50939 6.55073 4.1504C6.55073 3.79142 6.25971 3.5004 5.90073 3.5004V4.1504V4.8004ZM0.650569 6.12516C0.291584 6.12516 0.000568688 6.41618 0.000568688 6.77516C0.000568688 7.13415 0.291584 7.42516 0.650569 7.42516V6.77516V6.12516ZM4.15068 7.42516C4.50966 7.42516 4.80068 7.13415 4.80068 6.77516C4.80068 6.41618 4.50966 6.12516 4.15068 6.12516V6.77516V7.42516ZM11.5881 1.7504C11.2291 1.7504 10.9381 2.04142 10.9381 2.4004C10.9381 2.75939 11.2291 3.0504 11.5881 3.0504V2.4004V1.7504ZM17.0339 4.70128L16.4616 5.00945L16.4616 5.00948L17.0339 4.70128ZM15.6101 2.70991L15.9434 2.15187V2.15187L15.6101 2.70991ZM15.5265 12.9003H14.8765C14.8765 13.5079 14.3839 14.0004 13.7764 14.0004V14.6504V15.3004C15.1019 15.3004 16.1764 14.2259 16.1764 12.9003H15.5265ZM13.7764 14.6504V14.0004C13.1689 14.0004 12.6763 13.5079 12.6763 12.9003H12.0263H11.3763C11.3763 14.2259 12.4509 15.3004 13.7764 15.3004V14.6504ZM12.0263 12.9003H12.6763C12.6763 12.2928 13.1689 11.8003 13.7764 11.8003V11.1503V10.5003C12.4509 10.5003 11.3763 11.5748 11.3763 12.9003H12.0263ZM13.7764 11.1503V11.8003C14.3839 11.8003 14.8765 12.2928 14.8765 12.9003H15.5265H16.1764C16.1764 11.5748 15.1019 10.5003 13.7764 10.5003V11.1503ZM6.77665 12.9005H6.12665C6.12665 13.508 5.63414 14.0005 5.0266 14.0005V14.6505V15.3005C6.35211 15.3005 7.42665 14.226 7.42665 12.9005H6.77665ZM5.0266 14.6505V14.0005C4.41906 14.0005 3.92655 13.508 3.92655 12.9005H3.27655H2.62655C2.62655 14.226 3.70109 15.3005 5.0266 15.3005V14.6505ZM3.27655 12.9005H3.92655C3.92655 12.2929 4.41906 11.8004 5.0266 11.8004V11.1504V10.5004C3.70109 10.5004 2.62655 11.5749 2.62655 12.9005H3.27655ZM5.0266 11.1504V11.8004C5.63414 11.8004 6.12665 12.2929 6.12665 12.9005H6.77665H7.42665C7.42665 11.5749 6.35211 10.5004 5.0266 10.5004V11.1504ZM18.1509 6.77558H17.5009V8.52563H18.1509H18.8009V6.77558H18.1509ZM14.0383 6.77558V7.42558H18.1509V6.77558V6.12558H14.0383V6.77558ZM18.1509 8.52563H17.5009C17.5009 9.57524 17.4995 10.297 17.4266 10.8394C17.3562 11.363 17.23 11.621 17.0506 11.8004L17.5102 12.26L17.9698 12.7197C18.4311 12.2584 18.6253 11.6804 18.715 11.0126C18.8023 10.3635 18.8009 9.53848 18.8009 8.52563H18.1509ZM7.91311 0.650391V1.30039C8.94091 1.30039 9.30065 1.30841 9.57348 1.39706L9.77434 0.778871L9.9752 0.160684C9.45718 -0.00762862 8.83972 0.000390649 7.91311 0.000390649V0.650391ZM11.5882 4.3255H12.2382C12.2382 3.39889 12.2462 2.78143 12.0779 2.26341L11.4597 2.46428L10.8416 2.66514C10.9302 2.93797 10.9382 3.29771 10.9382 4.3255H11.5882ZM9.77434 0.778871L9.57348 1.39706C10.1748 1.59243 10.6462 2.06385 10.8416 2.66514L11.4597 2.46428L12.0779 2.26342C11.754 1.26636 10.9723 0.484649 9.9752 0.160685L9.77434 0.778871ZM11.5882 4.3255H10.9382C10.9382 4.92638 10.9302 5.38097 11.0557 5.76718L11.6739 5.56632L12.2921 5.36546C12.2462 5.22444 12.2382 5.02756 12.2382 4.3255H11.5882ZM14.0383 6.77558V6.12558C13.3362 6.12558 13.1394 6.11756 12.9983 6.07174L12.7975 6.68992L12.5966 7.30811C12.9828 7.4336 13.4374 7.42558 14.0383 7.42558V6.77558ZM11.6739 5.56632L11.0557 5.76718C11.2931 6.49785 11.866 7.0707 12.5966 7.30811L12.7975 6.68992L12.9983 6.07174C12.6634 5.96292 12.4009 5.70036 12.2921 5.36546L11.6739 5.56632ZM3.27547 12.8767L3.30783 12.2275C2.36654 12.1805 1.9913 12.041 1.75073 11.8004L1.29111 12.26L0.831495 12.7197C1.44298 13.3311 2.26508 13.4771 3.24311 13.5259L3.27547 12.8767ZM12.0263 12.9003L12.0263 12.2503L6.77553 12.2508L6.77558 12.9008L6.77563 13.5508L12.0264 13.5503L12.0263 12.9003ZM15.5258 12.8767L15.5582 13.5259C16.5362 13.4771 17.3583 13.3311 17.9698 12.7197L17.5102 12.26L17.0506 11.8004C16.81 12.041 16.4348 12.1805 15.4935 12.2275L15.5258 12.8767ZM0.650391 0.650391V1.30039H7.91311V0.650391V0.000390649H0.650391V0.650391ZM0.674498 10.2757L0.0253041 10.308C0.0740557 11.2861 0.220013 12.1082 0.831495 12.7197L1.29111 12.26L1.75073 11.8004C1.51017 11.5599 1.37061 11.1846 1.32369 10.2433L0.674498 10.2757ZM0.650569 4.1504V4.8004H5.90073V4.1504V3.5004H0.650569V4.1504ZM0.650569 6.77516V7.42516H4.15068V6.77516V6.12516H0.650569V6.77516ZM11.5881 2.4004V3.0504H13.1817V2.4004V1.7504H11.5881V2.4004ZM17.0339 4.70128L16.4616 5.00948L17.5786 7.08377L18.1509 6.77558L18.7232 6.46738L17.6062 4.39309L17.0339 4.70128ZM13.1817 2.4004V3.0504C13.8314 3.0504 14.2708 3.05116 14.6138 3.0858C14.9422 3.11896 15.1281 3.17913 15.2768 3.26794L13.473 2.70991L15.9434 2.15187C15.5739 1.93117 15.1823 1.83659 14.7444 1.79238C14.3211 1.74964 13.8054 1.7504 13.1817 1.7504V2.4004ZM17.0339 4.70128L17.6062 4.39312C17.3105 3.84393 17.0666 3.3895 16.8283 3.03709C16.5818 2.67251 16.3129 2.37257 15.9434 2.15187L15.6101 2.70991L15.2768 3.26794C15.4254 3.35675 15.5665 3.49187 15.7514 3.7653C15.9445 4.05088 16.1535 4.43739 16.4616 5.00945L17.0339 4.70128Z" fill="#141414" fill-opacity="0.8"/>
                           </svg>
                           Delivery & Return
                        </button>
                        <button type="button" class="aq-product-details-action-sm-btn" data-bs-target="#exampleModalToggle6" data-bs-toggle="modal">
                           <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                              <path d="M11.2504 4.95C12.4102 4.95 13.3504 4.0098 13.3504 2.85C13.3504 1.6902 12.4102 0.75 11.2504 0.75C10.0906 0.75 9.15039 1.6902 9.15039 2.85C9.15039 4.0098 10.0906 4.95 11.2504 4.95Z" stroke="#141414" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M2.85 9.85039C4.0098 9.85039 4.95 8.91019 4.95 7.75039C4.95 6.59059 4.0098 5.65039 2.85 5.65039C1.6902 5.65039 0.75 6.59059 0.75 7.75039C0.75 8.91019 1.6902 9.85039 2.85 9.85039Z" stroke="#141414" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M11.2504 14.7498C12.4102 14.7498 13.3504 13.8096 13.3504 12.6498C13.3504 11.49 12.4102 10.5498 11.2504 10.5498C10.0906 10.5498 9.15039 11.49 9.15039 12.6498C9.15039 13.8096 10.0906 14.7498 11.2504 14.7498Z" stroke="#141414" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M4.66309 8.80664L9.44409 11.5926" stroke="#141414" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M9.43709 3.90723L4.66309 6.69323" stroke="#141414" stroke-opacity="0.8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>
                           Share
                        </button>
                     </div>

                     <!-- product-message -->
                     <div class="aq-product-details-mesg-wrap">
                        <ul>
                           <li>
                              <div class="aq-product-details-mesg d-flex align-items-center">
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                                       <path d="M22.2581 20.2907C22.0349 20.0702 21.5886 20.0702 21.3655 20.2907C20.8077 20.8421 19.8035 20.8421 19.2457 20.2907C19.0226 20.0702 18.7994 19.9599 18.4647 19.7393L21.1423 12.6817C21.4771 11.9098 21.1423 11.0276 20.473 10.5865L16.7912 7.93987V4.0802C16.7912 3.6391 16.568 3.19799 16.2333 2.86716C15.8986 2.53634 15.4524 2.31579 15.0061 2.31579H14.1135V1.76441C14.1135 0.771929 13.3325 0 12.3284 0H10.3202C9.31604 0 8.53508 0.771929 8.53508 1.76441V2.31579H7.64253C7.19622 2.31579 6.74993 2.53634 6.41523 2.86716C5.85739 3.19799 5.74581 3.6391 5.74581 4.0802V7.93987L1.84089 10.5865C1.17148 11.0276 0.948342 11.9098 1.17148 12.6817L3.84914 19.8496C3.626 19.9599 3.40286 20.1805 3.17972 20.2907C2.62187 20.8421 1.61775 20.8421 1.05991 20.2907C0.83677 20.0702 0.390492 20.0702 0.167354 20.2907C-0.0557846 20.5113 -0.0557846 20.9524 0.167354 21.1729C1.28304 22.2757 3.06815 22.2757 4.18385 21.1729C4.74169 20.6215 5.74581 20.6215 6.30366 21.1729C7.41935 22.2757 9.20445 22.2757 10.3202 21.1729C10.878 20.6215 11.8821 20.6215 12.44 21.1729C13.5557 22.2757 15.3408 22.2757 16.4565 21.1729C17.0143 20.6215 18.0184 20.6215 18.5763 21.1729C19.1341 21.7243 19.8035 21.9449 20.5846 21.9449C21.3655 21.9449 22.0349 21.614 22.5927 21.1729C22.5927 20.9524 22.5927 20.6216 22.2581 20.2907ZM9.76231 1.76441C9.76231 1.54386 9.98541 1.32331 10.2086 1.32331H12.2169C12.44 1.32331 12.6631 1.54386 12.6631 1.76441V2.31579H9.65072V1.76441H9.76231ZM7.08464 4.0802C7.08464 3.96992 7.08464 3.85965 7.19622 3.74937C7.30778 3.6391 7.41935 3.6391 7.53094 3.6391H15.0061C15.1176 3.6391 15.2292 3.6391 15.3408 3.74937C15.4524 3.85965 15.4524 3.96992 15.4524 4.0802V6.94736L11.659 4.41103C11.4358 4.30075 11.1011 4.30075 10.878 4.41103L7.08464 7.05764V4.0802ZM2.62187 11.6892L11.2127 5.84461L19.8035 11.7995C19.9151 11.9098 20.0267 12.1304 19.9151 12.3509L19.0226 14.777L11.659 9.70427C11.4358 9.59398 11.1011 9.59398 10.878 9.70427L3.40286 14.6667L2.51031 12.1304C2.39874 12.0201 2.39874 11.7995 2.62187 11.6892ZM15.2292 20.2907C14.6713 20.8421 13.6673 20.8421 13.1094 20.2907C11.9937 19.188 10.2086 19.188 9.09286 20.2907C8.53508 20.8421 7.53094 20.8421 6.97308 20.2907C6.41523 19.7394 5.74581 19.5188 4.96483 19.5188L3.626 15.99L11.2127 11.0276L18.5763 16.1003L17.2375 19.6291C16.4564 19.5188 15.787 19.7394 15.2292 20.2907Z" fill="currentcolor"/>
                                    </svg>
                                 </span>
                                 <span><label>Estimate delivery times:</label> 5-7 days International.</span>
                              </div>
                           </li>
                           <li>
                              <div class="aq-product-details-mesg d-flex align-items-center">
                                 <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                       <path d="M12.7023 7.23009L4.63379 2.57715M0.84082 5.04395L8.66728 9.57137L16.4937 5.04395M8.66797 18.5996V9.56268M16.7366 13.1491V5.97689C16.7363 5.66246 16.6533 5.35364 16.496 5.08142C16.3386 4.80919 16.1124 4.58313 15.8401 4.42591L9.56463 0.839831C9.29205 0.682459 8.98286 0.599609 8.66812 0.599609C8.35339 0.599609 8.04419 0.682459 7.77162 0.839831L1.49611 4.42591C1.22381 4.58313 0.997638 4.80919 0.840286 5.08142C0.682933 5.35364 0.599932 5.66246 0.599609 5.97689V13.1491C0.599932 13.4635 0.682933 13.7723 0.840286 14.0445C0.997638 14.3168 1.22381 14.5428 1.49611 14.7L7.77162 18.2861C8.04419 18.4435 8.35339 18.5263 8.66812 18.5263C8.98286 18.5263 9.29205 18.4435 9.56463 18.2861L15.8401 14.7C16.1124 14.5428 16.3386 14.3168 16.496 14.0445C16.6533 13.7723 16.7363 13.4635 16.7366 13.1491Z" stroke="currentcolor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </span>
                                 <span><label>Free shipping & returns:</label> On all orders over $150.</span>
                              </div>
                           </li>
                        </ul>
                     </div>

                     <!-- product-message -->
                     <div class="aq-product-details-payment d-flex align-items-center justify-content-between">
                        <p>Guaranteed safe <br> and secure checkout</p>
                        <img src="<?= $bazaro; ?>img/payment/payment.png" alt="">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- product details area end -->

      <!-- Content -->
      <div class="product-details-tab pb-140">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="product-details-tab-nav">
                     <nav>
                        <div class="product-details-nav nav nav-tab justify-content-center p-relative" id="navPresentationTab" role="tablist">
                           <button class="nav-links active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">Description</button>
                           <button class="nav-links" id="nav-addInfo-tab" data-bs-toggle="tab" data-bs-target="#nav-addInfo" type="button" role="tab" aria-controls="nav-addInfo" aria-selected="false">Additional information</button>
                           <button class="nav-links" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Reviews (4)</button>
                           <button class="nav-links" id="nav-question-tab" data-bs-toggle="tab" data-bs-target="#nav-question" type="button" role="tab" aria-controls="nav-question" aria-selected="false">Ask & Question</button>
                           <button class="nav-links" id="nav-faq-tab" data-bs-toggle="tab" data-bs-target="#nav-faq" type="button" role="tab" aria-controls="nav-faq" aria-selected="false">Faq</button>
                        </div>
                     </nav>  
                     <div class="tab-content" id="navPresentationTabContent">
                        <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" tabindex="0">
                           <div class="product-details-tab-item">
                              <div class="product-details-desc-wrap">
                                 <h3 class="product-details-desc-title">Fashion Clothes Outfits for Women</h3>
                                 <p class="mb-50">
                                    At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias
                                    excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum
                                    facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil
                                 </p>
                                 <div class="row">
                                    <div class="col-xl-8">
                                       <div class="row">
                                          <div class="col-xl-6">
                                             <div class="product-details-desc-list">
                                                <h4 class="product-details-desc-list-title">Features</h4>
                                                <ul>
                                                   <li>Cutaway collar</li>
                                                   <li>Chest patch pocket</li>
                                                   <li>Babaton embroidered crest</li>
                                                   <li>Adjustable sleeve tabs</li>
                                                </ul>
                                             </div>
                                          </div>
                                          <div class="col-xl-6">
                                             <div class="product-details-desc-list">
                                                <h4 class="product-details-desc-list-title">Composition</h4>
                                                <ul>
                                                   <li>Care: Hand wash</li>
                                                   <li>Content: 100% LENZING™ ECOVERO™ Viscose</li>
                                                   <li>Imported</li>
                                                </ul>
                                             </div>
                                          </div>
                                          <div class="col-xl-6">
                                             <div class="product-details-desc-icon-wrap">
                                                <h4 class="product-details-desc-list-title">Washing Instructions</h4>
                                                <div class="product-details-desc-icon">
                                                   <img src="<?= $bazaro; ?>img/icon/washing-img.png" alt="">
                                                </div>
                                                <p>Machine wash, no ironing, don’t dry clean, don’t tumble dry</p>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-4">
                                       <div class="product-details-desc-img">
                                          <img src="<?= $bazaro; ?>img/product-details/product-desc-img.jpg" alt="">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="nav-addInfo" role="tabpanel" aria-labelledby="nav-addInfo-tab" tabindex="0">
                           <div class="product-details-tab-item">
                              <div class="product-details-additional-info">
                                 <div class="row">
                                    <div class="col-xl-12">
                                       <h4 class="product-details-additional-info-title">Additional information</h4>
                                       <table>
                                          <tbody>
                                             <tr>
                                                <td>Brand</td>
                                                <td>Sulwhasoo</td>
                                             </tr>
                                             <tr>
                                                <td>Color</td>
                                                <td>Orange, Dark, Pink</td>
                                             </tr>
                                             <tr>
                                                <td>Use for</td>
                                                <td>Whole Body</td>
                                             </tr>
                                             <tr>
                                                <td>Product Dimensions</td>
                                                <td>2.04 x 2.66 x 5.4 inches; 1.7 Ounces</td>
                                             </tr>
                                             <tr>
                                                <td>Item Volume</td>
                                                <td>50 Milliliters</td>
                                             </tr>
                                             <tr>
                                                <td>Item Form</td>
                                                <td>Cream</td>
                                             </tr>
                                             <tr>
                                                <td>Country of Origin</td>
                                                <td>USA</td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab" tabindex="0">
                           <div class="product-details-tab-item">
                              <div class="product-details-review-wrapper">
                                 <div class="row">
                                    <div class="col-xl-6">
                                       <div class="product-details-review-statics mb-30">
                                          <!-- number -->
                                          <div class="product-details-review-number d-inline-block mb-50">
                                             <h3 class="product-details-review-number-title">Customer reviews</h3>
                                             <div class="product-details-review-summery d-flex align-items-center">
                                                <div class="product-details-review-summery-value">
                                                   <span>4.5</span>
                                                </div>
                                                <div class="product-details-review-summery-rating d-flex align-items-center">
                                                   <span>
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                         <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                      </svg>
                                                   </span>
                                                   <span>
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                         <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                      </svg>
                                                   </span>
                                                   <span>
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                         <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                      </svg>
                                                   </span>
                                                   <span>
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                         <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                      </svg>
                                                   </span>
                                                   <span>
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                         <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                      </svg>
                                                   </span>
                                                   <p>(36 Reviews)</p>
                                                </div>
                                             </div>
                                             <div class="product-details-review-rating-list">
                                                <div class="product-details-review-rating-item d-flex align-items-center">
                                                   <span>5 Start</span>
                                                   <div class="product-details-review-rating-bar">
                                                      <span class="product-details-review-rating-bar-inner" data-width="82%"></span>
                                                   </div>
                                                   <div class="product-details-review-rating-percent">
                                                      <span>82%</span>
                                                   </div>
                                                </div>
                                                <div class="product-details-review-rating-item d-flex align-items-center">
                                                   <span>4 Start</span>
                                                   <div class="product-details-review-rating-bar">
                                                      <span class="product-details-review-rating-bar-inner" data-width="30%"></span>
                                                   </div>
                                                   <div class="product-details-review-rating-percent">
                                                      <span>30%</span>
                                                   </div>
                                                </div>
                                                <div class="product-details-review-rating-item d-flex align-items-center">
                                                   <span>3 Start</span>
                                                   <div class="product-details-review-rating-bar">
                                                      <span class="product-details-review-rating-bar-inner" data-width="15%"></span>
                                                   </div>
                                                   <div class="product-details-review-rating-percent">
                                                      <span>15%</span>
                                                   </div>
                                                </div>
                                                <div class="product-details-review-rating-item d-flex align-items-center">
                                                   <span>2 Start</span>
                                                   <div class="product-details-review-rating-bar">
                                                      <span class="product-details-review-rating-bar-inner" data-width="6%"></span>
                                                   </div>
                                                   <div class="product-details-review-rating-percent">
                                                      <span>6%</span>
                                                   </div>
                                                </div>
                                                <div class="product-details-review-rating-item d-flex align-items-center">
                                                   <span>1 Start</span>
                                                   <div class="product-details-review-rating-bar">
                                                      <span class="product-details-review-rating-bar-inner" data-width="10%"></span>
                                                   </div>
                                                   <div class="product-details-review-rating-percent">
                                                      <span>10%</span>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
   
                                          <!-- reviews -->
                                          <div class="product-details-review-list pr-110">
                                             <h3 class="product-details-review-title">Rating & Review</h3>
                                             <div class="product-details-review-avater d-flex align-items-start">
                                                <div class="product-details-review-avater-thumb">
                                                   <a href="#">
                                                      <img src="<?= $bazaro; ?>img/avater/avater-1.jpg" alt="">
                                                   </a>
                                                </div>
                                                <div class="product-details-review-avater-content">
                                                   <div class="product-details-review-avater-rating d-flex align-items-center">
                                                      <?php for ($s = 0; $s < 5; $s++): ?>
                                                      <span>
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                         </svg>
                                                      </span>
                                                      <?php endfor; ?>
                                                   </div>
                                                   <h3 class="product-details-review-avater-title">Eleanor Fant</h3>
                                                   <span class="product-details-review-avater-meta">06 March, 2023 </span>
                                                   <div class="product-details-review-avater-comment">
                                                      <p>Designed very similarly to the nearly double priced Galaxy tab S6, with the only removal being.</p>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="product-details-review-avater d-flex align-items-start">
                                                <div class="product-details-review-avater-thumb">
                                                   <a href="#">
                                                      <img src="<?= $bazaro; ?>img/avater/avater-2.jpg" alt="">
                                                   </a>
                                                </div>
                                                <div class="product-details-review-avater-content">
                                                   <div class="product-details-review-avater-rating d-flex align-items-center">
                                                      <?php for ($s = 0; $s < 5; $s++): ?>
                                                      <span>
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                         </svg>
                                                      </span>
                                                      <?php endfor; ?>
                                                   </div>
                                                   <h3 class="product-details-review-avater-title">Orio Madrid</h3>
                                                   <span class="product-details-review-avater-meta">06 January, 2026</span>
                                                   <div class="product-details-review-avater-comment">
                                                      <p>This review is for the Samsung Tab S6 Lite, 64gb wifi in blue. purchased this product performed.</p>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                       </div>
                                    </div> <!-- end col -->
                                    <div class="col-xl-6">
                                       <div class="product-details-review-form mb-30">
                                          <h3 class="product-details-review-form-title">Review this product</h3>
                                          <p>Your email address will not be published. Required fields are marked *</p>
                                          <form action="#" onsubmit="event.preventDefault(); if(typeof showEltToast==='function')showEltToast('Review submitted!');">
                                             <div class="product-details-review-form-rating d-flex align-items-center">
                                                <p>Your Rating :</p>
                                                <div class="product-details-review-form-rating-icon d-flex align-items-center">
                                                   <?php for ($s = 0; $s < 5; $s++): ?>
                                                   <span>
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                         <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"/>
                                                      </svg>
                                                   </span>
                                                   <?php endfor; ?>
                                                </div>
                                             </div>
                                             <div class="product-details-review-input-wrapper">
                                                <div class="product-details-review-input-box">
                                                   <label class="aq-form-label" for="msg">Your Review *</label>
                                                   <textarea class="aq-form-control brr-0" id="msg" name="msg" placeholder="Write your review here..."></textarea>
                                                </div>
                                                <div class="product-details-review-input-box">
                                                   <label class="aq-form-label" for="name">Your Name*</label>
                                                   <input class="aq-form-control brr-0" name="name" id="name" type="text" placeholder="bazaro">
                                                </div>
                                                <div class="product-details-review-input-box">
                                                   <label class="aq-form-label" for="email">Your Email*</label>
                                                   <input class="aq-form-control brr-0" name="email" id="email" type="email" placeholder="bazaro@mail.com">
                                                </div>
                                             </div>
                                             <div class="product-details-review-suggetions mb-20">
                                                <div class="product-details-review-remeber">
                                                   <input class="aq-form-checkbox" id="remeber" type="checkbox">
                                                   <label class="aq-form-checkbox-label" for="remeber">Save my name, email, and website in this browser for the next time I comment.</label>
                                                </div>
                                             </div>
                                             <div class="product-details-review-btn-wrapper">
                                                <button type="submit" class="aq-btn-black">Submit Review</button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="aq-product-details-review-header-container mt-50">
                                          <div class="aq-product-details-review-header-left">
                                             <h3 class="product-details-review-title">Product Reviews</h3>
                                          </div>
                                          
                                          <div class="aq-product-details-review-header-right">
                                             <div class="aq-product-details-review-header-action-item">
                                                <span class="aq-product-details-review-header-label">Sort:</span>
                                                <div class="aqf-bundle-select aq-select">
                                                   <select>
                                                      <option>Relevance</option>
                                                      <option>Most Recent</option>
                                                   </select>
                                                </div>
                                             </div>

                                             <div class="aq-product-details-review-header-action-item">
                                                <span class="aq-product-details-review-header-icon">
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                                      <path d="M11.75 0.75H0.750015L5.15002 6.00556V9.63889L7.35002 10.75V6.00556L11.75 0.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                   </svg>
                                                </span>
                                                <span class="aq-product-details-review-header-label">Filter:</span>
                                                <div class="aqf-bundle-select aq-select">
                                                   <select>
                                                      <option>All star</option>
                                                      <option>5 Star</option>
                                                      <option>4 Star</option>
                                                      <option>3 Star</option>
                                                      <option>2 Star</option>
                                                      <option>1 Star</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="aq-product-details-review">
                                          <div class="aq-product-details-review-container">
                                             <div class="aq-product-details-review-item">
                                                <div class="aq-product-details-review-top">
                                                   <div class="product-details-review-avater-rating d-flex align-items-center">
                                                      <?php for ($s = 0; $s < 5; $s++): ?>
                                                      <span>
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"></path>
                                                         </svg>
                                                      </span>
                                                      <?php endfor; ?>
                                                   </div>
                                                   <span class="aq-product-details-review-date">13 Dec 2025</span>
                                                </div>
                                                
                                                <div class="aq-product-details-review-user">
                                                   <span class="aq-product-details-review-user-name">0***7</span>
                                                   <span class="aq-product-details-review-verified">
                                                      <i class="fas fa-check-circle"></i> Verified Purchase
                                                   </span>
                                                </div>

                                                <p class="aq-product-details-review-text">
                                                   Have to wait long time at collection point due to only one delivery counter and long que for receiving products. But the product quality is genuine.
                                                </p>

                                                <div class="aq-product-details-review-gallery">
                                                   <div class="aq-product-details-review-thumb">
                                                      <img src="<?= $bazaro; ?>img/fashion-1/product/product-1/front-img-1.jpg" alt="Review Image">
                                                   </div>
                                                </div>

                                                <div class="aq-product-details-review-footer">
                                                   <div class="aq-product-details-review-helpful">
                                                      <i class="far fa-thumbs-up"></i>
                                                      <span>5</span>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="aq-product-details-review-item">
                                                <div class="aq-product-details-review-top">
                                                   <div class="product-details-review-avater-rating d-flex align-items-center">
                                                      <?php for ($s = 0; $s < 5; $s++): ?>
                                                      <span>
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M9.55008 7.09107C9.3947 7.24165 9.32331 7.45942 9.3587 7.673L9.89203 10.6246C9.93703 10.8748 9.83144 11.1279 9.62207 11.2725C9.4169 11.4225 9.14393 11.4405 8.92016 11.3205L6.26311 9.9347C6.17072 9.88551 6.06813 9.85911 5.96315 9.85611H5.80057C5.74417 9.86451 5.68898 9.88251 5.63859 9.9101L2.98094 11.3025C2.84955 11.3685 2.70077 11.3919 2.55499 11.3685C2.19984 11.3013 1.96287 10.963 2.02106 10.606L2.55499 7.6544C2.59039 7.43903 2.519 7.22006 2.36362 7.06708L0.1973 4.96735C0.0161234 4.79157 -0.0468684 4.52761 0.0359208 4.28944C0.11631 4.05187 0.321483 3.87849 0.569251 3.8395L3.55086 3.40695C3.77763 3.38356 3.97681 3.24558 4.07879 3.0416L5.39262 0.347955C5.42382 0.287962 5.46401 0.23277 5.51261 0.185976L5.5666 0.143981C5.59479 0.112785 5.62719 0.0869886 5.66319 0.0659914L5.72858 0.0419945L5.83056 0H6.08313C6.3087 0.0233969 6.50728 0.158379 6.61106 0.359953L7.94229 3.0416C8.03828 3.23778 8.22485 3.37396 8.44022 3.40695L11.4218 3.8395C11.6738 3.87549 11.8844 4.04947 11.9678 4.28944C12.0464 4.53001 11.9786 4.79397 11.7938 4.96735L9.55008 7.09107Z" fill="currentcolor"></path>
                                                         </svg>
                                                      </span>
                                                      <?php endfor; ?>
                                                   </div>
                                                   <span class="aq-product-details-review-date">23 Oct 2025</span>
                                                </div>
                                                
                                                <div class="aq-product-details-review-user">
                                                   <span class="aq-product-details-review-user-name">Golam Rahman</span>
                                                   <span class="aq-product-details-review-verified">
                                                      <i class="fas fa-check-circle"></i> Verified Purchase
                                                   </span>
                                                </div>

                                                <p class="aq-product-details-review-text">
                                                   Stylish and comfortable. The design looks just like the photos, though I wish the material were slightly thicker.
                                                </p>

                                                <div class="aq-product-details-review-gallery">
                                                   <div class="aq-product-details-review-thumb">
                                                      <img src="<?= $bazaro; ?>img/fashion-1/product/product-1/front-img-1.jpg" alt="Review Image">
                                                   </div>
                                                   <div class="aq-product-details-review-thumb">
                                                      <img src="<?= $bazaro; ?>img/fashion-1/product/product-1/front-img-2.jpg" alt="Review Image">
                                                   </div>
                                                   <div class="aq-product-details-review-thumb">
                                                      <img src="<?= $bazaro; ?>img/fashion-1/product/product-1/front-img-3.jpg" alt="Review Image">
                                                   </div>
                                                </div>

                                                <div class="aq-product-details-review-footer">
                                                   <div class="aq-product-details-review-helpful">
                                                      <i class="far fa-thumbs-up"></i>
                                                      <span>2</span>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="nav-question" role="tabpanel" aria-labelledby="nav-question-tab" tabindex="0">
                           <div class="product-details-tab-item">
                              <div class="product-details-question-container">
                                 <div class="product-details-question-header">
                                    <div class="product-details-question-header-left">
                                       <h3 class="product-details-policy-title">Questions (4)</h3>
                                       <p class="m-0">Have question about this product? Get specific details about this product from expert.</p>
                                    </div>
                                    <div class="product-details-question-header-right">
                                       <button type="button" class="aq-btn-black btn-red-bg btn-square" data-bs-target="#exampleModalToggle4" data-bs-toggle="modal">Ask Question</button>
                                    </div>
                                 </div>

                                 <div class="product-details-question-list">
                                    
                                    <div class="product-details-question-item">
                                       <p class="product-details-question-meta">
                                          <span class="product-details-question-user">Faiza Rahman</span> on 03 Dec 2025
                                       </p>
                                       <div class="product-details-question-row">
                                          <span class="product-details-question-label">Q:</span>
                                          <p class="product-details-question-text product-details-question-text--bold">What is the screen size of the COLMI P81?</p>
                                       </div>
                                       <div class="product-details-question-row">
                                          <span class="product-details-question-label">A:</span>
                                          <p class="product-details-question-text text-ans">COLMI P81 Smart Watch has a 1.9-inch TFT HD display with 240×284 resolution and a 95% screen-to-body ratio</p>
                                       </div>
                                    </div>

                                    <div class="product-details-question-item">
                                       <p class="product-details-question-meta">
                                          <span class="product-details-question-user">Akbar Islam</span> on 24 Feb 2025
                                       </p>
                                       <div class="product-details-question-row">
                                          <span class="product-details-question-label">Q:</span>
                                          <p class="product-details-question-text product-details-question-text--bold">How long does the battery last on the COLMI P81?</p>
                                       </div>
                                       <div class="product-details-question-row">
                                          <span class="product-details-question-label">A:</span>
                                          <p class="product-details-question-text text-ans">This COLMI P81 Smart Watch battery lasts up to 7 days on normal usage.</p>
                                       </div>
                                    </div>

                                    <div class="product-details-question-item">
                                       <p class="product-details-question-meta">
                                          <span class="product-details-question-user">Fazle Hasan Abed</span> on 02 Feb 2025
                                       </p>
                                       <div class="product-details-question-row">
                                          <span class="product-details-question-label">Q:</span>
                                          <p class="product-details-question-text product-details-question-text--bold">What is the resolution of the COLMI P81 Smart Watch?</p>
                                       </div>
                                       <div class="product-details-question-row">
                                          <span class="product-details-question-label">A:</span>
                                          <p class="product-details-question-text text-ans">The resolution of the COLMI P81 Smart Watch is 240x284 pixels.</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="nav-faq" role="tabpanel" aria-labelledby="nav-faq-tab" tabindex="0">
                           <div class="product-details-tab-item">
                              <div class="aq-faq-wrap">
                                 <div class="accordion" id="accordionExample">
                                    <div class="accordion-items">
                                       <div class="accordion-header">
                                          <button class="accordion-buttons" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                             What is Emeritus Education System?
                                             <span class="aq-faq-icon"></span>
                                          </button>
                                       </div>
                                       <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua.
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="accordion-items">
                                       <div class="accordion-header">
                                          <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                             Can I get a refund for my Premium Membership payment?
                                             <span class="aq-faq-icon"></span>
                                          </button>
                                       </div>
                                       <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua.
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="accordion-items">
                                       <div class="accordion-header">
                                          <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                             How does th Affiliate Program work?
                                             <span class="aq-faq-icon"></span>
                                          </button>
                                       </div>
                                       <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua.
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="accordion-items">
                                       <div class="accordion-header">
                                          <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                             What is included in Standard membership plan?
                                             <span class="aq-faq-icon"></span>
                                          </button>
                                       </div>
                                       <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua.
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="accordion-items">
                                       <div class="accordion-header">
                                          <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                             How to choose the right class for me?
                                             <span class="aq-faq-icon"></span>
                                          </button>
                                       </div>
                                       <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua.
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="accordion-items">
                                       <div class="accordion-header">
                                          <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                             How does th Affiliate Program work?
                                             <span class="aq-faq-icon"></span>
                                          </button>
                                       </div>
                                       <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                          <div class="accordion-body">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt <br> ut labore et dolore magna aliqua.
                                             </p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>                                                
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Content -->

   </main>
