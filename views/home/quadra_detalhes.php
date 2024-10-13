<?php
require_once '../../models/Owner.php';
require_once '../../models/Client.php';
require_once '../../models/User.php';
// Verifica se o ID foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die('ID da quadra não fornecido ou inválido.');
}

$id_quadra = (int) $_GET['id'];

// Busca os detalhes da quadra
$quadra = User::getQuadraById($id_quadra);

if (!$quadra) {
  die('Quadra não encontrada.');
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($quadra['nome_espaco']); ?> <?php echo htmlspecialchars($quadra['nome']); ?> | ©
    2024 Arena Rental, Inc.</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../../resources/css/detalhes_quadra.css?v=<?= time() ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php include '../layouts/header.php'; ?>

  <section>
  <?php include '../layouts/mensagem.php'; ?>
    <h1><?php echo htmlspecialchars($quadra['nome_espaco']); ?> <?php echo htmlspecialchars($quadra['nome']); ?></h1>
    <div class="container">

      <div id="images-container">
        <?php if (!empty($quadra['imagem_quadra'])): ?>
          <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
            alt="<?php echo htmlspecialchars($quadra['nome']); ?>" class="quadra-image-large">
        <?php endif; ?>

        <div id="mini-images-container" class="mini-images">
          <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
            alt="<?php echo htmlspecialchars($quadra['nome']); ?>" class="quadra-image-large">
          <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
            alt="<?php echo htmlspecialchars($quadra['nome']); ?>" class="quadra-image-large">
        </div>

        <div id="mini-images-container">
          <div id="mini1"> <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
              alt="<?php echo htmlspecialchars($quadra['nome']); ?>" class="quadra-image-large"></div>
          <div id="mini2"> <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
              alt="<?php echo htmlspecialchars($quadra['nome']); ?>" class="quadra-image-large"></div>
        </div>
      </div>

      <h2 id="container-info"><div><?php echo htmlspecialchars($quadra['esporte']); ?> , <?php echo htmlspecialchars($quadra['localizacao']); ?> - 
      <?php echo htmlspecialchars($quadra['cep']); ?></div> <b id="recursos"></b></h2>
      <h3 id="info-quadra"><div><?php echo $quadra['coberta'] ? 'Quadra coberta' : 'Quadra descoberta'; ?>, com </div><p id="recursos-texto"></p></h3>

    <?php
    // Defina a variável $recursos com os dados da quadra
    $recursos = json_decode(htmlspecialchars_decode($quadra['recursos']), true);
    ?>
 <script>
    // Recebendo os recursos do PHP via JSON
    const recursos = <?php echo json_encode($recursos); ?>;

    // Array para armazenar os SVGs correspondentes
    const icones = [];

    const svgBebedouro = `
 <svg width="25.5" height="25" viewBox="0 0 57 56" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20.2272 31.86C20.8976 31.185 20.8943 30.0942 20.2197 29.4233C19.5451 28.7525 18.4547 28.7557 17.7842 29.4307L20.2272 31.86ZM33.2927 39.2562L31.6174 38.8569L31.6151 38.8663L33.2927 39.2562ZM21.9405 22.2874C21.6802 23.2026 22.2108 24.1558 23.1256 24.4161C24.0404 24.6767 24.993 24.1457 25.2534 23.2304L21.9405 22.2874ZM36.8523 9.51023L41.7939 12.4887L43.5712 9.53685L38.6295 6.55834L36.8523 9.51023ZM20.94 46.3396L19.4145 45.4202L17.6372 48.3719L19.1627 49.2913L20.94 46.3396ZM31.5186 39.2875L30.9492 41.802L34.3083 42.5636L34.8778 40.049L31.5186 39.2875ZM18.1174 33.9375L19.9186 32.1653L17.5037 29.7082L15.7025 31.4802L18.1174 33.9375ZM31.5382 13.0043L38.5005 9.58066L36.9813 6.4879L30.019 9.91151L31.5382 13.0043ZM40.9659 11.1504L41.607 19.1567L45.0403 18.8815L44.3992 10.8752L40.9659 11.1504ZM39.2477 8.86851L40.227 7.09765L37.2135 5.42918L36.2339 7.20005L39.2477 8.86851ZM40.3868 7.05485L42.1795 8.13532L43.9567 5.18343L42.1641 4.10299L40.3868 7.05485ZM42.2206 8.28934L41.1758 10.1786L44.1896 11.847L45.2344 9.95781L42.2206 8.28934ZM41.607 19.1567C41.6249 19.3808 41.6323 19.4734 41.6378 19.5596L45.0752 19.3409C45.0674 19.2198 45.0573 19.0941 45.0403 18.8815L41.607 19.1567ZM40.2431 30.9297C40.3988 30.7926 40.4922 30.7106 40.5806 30.6299L38.2608 28.0826C38.1995 28.1384 38.1326 28.1974 37.9675 28.3426L40.2431 30.9297ZM41.6378 19.5596C41.8449 22.8174 40.5841 25.9648 38.2608 28.0826L40.5806 30.6299C43.6984 27.7878 45.3466 23.613 45.0752 19.3409L41.6378 19.5596ZM25.7774 20.8714C25.8153 20.6501 25.8309 20.5588 25.847 20.4742L22.4622 19.8358C22.4398 19.9549 22.4185 20.0791 22.3826 20.2889L25.7774 20.8714ZM30.019 9.91151C29.8346 10.0021 29.7237 10.0566 29.6178 10.111L31.1912 13.1766C31.2638 13.1393 31.3428 13.1004 31.5382 13.0043L30.019 9.91151ZM25.847 20.4742C26.4491 17.2779 28.4385 14.5908 31.1912 13.1766L29.6178 10.111C25.8844 12.0291 23.2541 15.6332 22.4622 19.8358L25.847 20.4742ZM19.9186 32.1653C20.0644 32.0219 20.1468 31.9408 20.2272 31.86L17.7842 29.4307C17.721 29.4943 17.655 29.5593 17.5037 29.7082L19.9186 32.1653ZM22.3826 20.2889C22.346 20.5022 22.3299 20.5963 22.3133 20.687L25.7014 21.3069C25.7223 21.1931 25.7421 21.0774 25.7774 20.8714L22.3826 20.2889ZM34.8778 40.049C34.9005 39.9482 34.9237 39.8473 34.9411 39.7713C34.9499 39.7336 34.9572 39.7021 34.9623 39.6801C34.9648 39.6691 34.9669 39.6606 34.968 39.6548C34.9687 39.6518 34.9692 39.6498 34.9696 39.6484C34.9694 39.6486 34.9698 39.6475 34.9696 39.6484C34.9696 39.6484 34.9701 39.6463 33.2927 39.2562C31.6151 38.8663 31.6151 38.8663 31.6151 38.8663C31.6151 38.8666 31.6153 38.8661 31.6151 38.8663C31.6151 38.8668 31.6146 38.8682 31.6144 38.8691C31.6142 38.8707 31.6135 38.873 31.6128 38.8762C31.6114 38.8824 31.6093 38.8914 31.6066 38.9029C31.6013 38.9258 31.5937 38.9585 31.5848 38.9978C31.5669 39.0759 31.5428 39.1811 31.5186 39.2875L34.8778 40.049ZM37.9675 28.3426C37.8146 28.4775 37.7278 28.5538 37.6433 28.63L39.9485 31.1905C40.0148 31.1308 40.0842 31.0696 40.2431 30.9297L37.9675 28.3426ZM19.4145 45.4202C17.9647 44.5462 16.9555 43.9367 16.2104 43.4122C15.472 42.8928 15.1264 42.5456 14.9273 42.2504L12.072 44.1777C12.6142 44.9818 13.3534 45.615 14.2287 46.2309C15.0972 46.8422 16.2304 47.5241 17.6372 48.3719L19.4145 45.4202ZM15.7025 31.4802C14.5239 32.6397 13.5755 33.5713 12.8688 34.3712C12.1568 35.1772 11.5827 35.9654 11.2377 36.8715L14.4565 38.0981C14.5857 37.7588 14.8468 37.3358 15.4495 36.6535C16.0575 35.9652 16.9035 35.1317 18.1174 33.9375L15.7025 31.4802ZM14.9273 42.2504C14.1125 41.042 13.9318 39.4765 14.4565 38.0981L11.2377 36.8715C10.3166 39.2914 10.6266 42.034 12.072 44.1777L14.9273 42.2504ZM19.1627 49.2913C20.5692 50.139 21.7019 50.823 22.644 51.3029C23.5901 51.7849 24.4966 52.1437 25.4578 52.234L25.78 48.8031C25.4587 48.7728 25.0096 48.6409 24.2068 48.2319C23.3999 47.8209 22.3901 47.2135 20.94 46.3396L19.1627 49.2913ZM30.9492 41.802C30.5657 43.4954 30.2964 44.6806 30.0282 45.5782C29.7614 46.4719 29.5391 46.921 29.3253 47.2034L32.0707 49.2844C32.6532 48.5152 33.0181 47.6036 33.3285 46.5647C33.6376 45.5293 33.9354 44.2099 34.3083 42.5636L30.9492 41.802ZM25.4578 52.234C28.0238 52.475 30.5069 51.3493 32.0707 49.2844L29.3253 47.2034C28.461 48.3447 27.1251 48.9294 25.78 48.8031L25.4578 52.234ZM42.1795 8.13532C42.3159 8.21759 42.4201 8.28038 42.5085 8.33563C42.5972 8.39086 42.6493 8.4258 42.6814 8.44885C42.7466 8.49565 42.6543 8.44218 42.5607 8.29531L45.4633 6.4403C45.2247 6.06665 44.9269 5.81954 44.6897 5.64907C44.469 5.49066 44.1992 5.32959 43.9567 5.18343L42.1795 8.13532ZM45.2344 9.95781C45.3714 9.70996 45.5246 9.43558 45.6367 9.18808C45.7572 8.92175 45.8918 8.5588 45.9117 8.11588L42.4709 7.96019C42.4789 7.78609 42.5319 7.69367 42.4989 7.76677C42.4826 7.80279 42.4548 7.8592 42.4057 7.9513C42.3565 8.04338 42.2977 8.14982 42.2206 8.28934L45.2344 9.95781ZM42.5607 8.29531C42.4968 8.19551 42.4656 8.07848 42.4709 7.96019L45.9117 8.11588C45.9384 7.52446 45.7818 6.93925 45.4633 6.4403L42.5607 8.29531ZM40.227 7.09765C40.3094 6.94869 40.3726 6.83444 40.4284 6.73723C40.4844 6.63996 40.5202 6.58168 40.5446 6.54529C40.5949 6.46986 40.5423 6.57081 40.3868 6.67334L38.4904 3.79672C38.0993 4.05479 37.8486 4.37899 37.6789 4.63339C37.5202 4.87156 37.3602 5.16356 37.2135 5.42918L40.227 7.09765ZM42.1641 4.10299C41.9042 3.94635 41.6199 3.77335 41.3634 3.6464C41.0895 3.51081 40.7104 3.35536 40.2426 3.32731L40.0364 6.76724C39.8507 6.75607 39.7547 6.69492 39.836 6.7351C39.8752 6.75451 39.9354 6.787 40.0323 6.84335C40.1292 6.89966 40.241 6.96702 40.3868 7.05485L42.1641 4.10299ZM40.3868 6.67334C40.2833 6.74174 40.1604 6.77466 40.0364 6.76724L40.2426 3.32731C39.6231 3.29014 39.0084 3.45482 38.4904 3.79672L40.3868 6.67334ZM25.2534 23.2304C25.4328 22.5994 25.5825 21.9575 25.7014 21.3069L22.3133 20.687C22.2143 21.2286 22.0897 21.7627 21.9405 22.2874L25.2534 23.2304ZM34.968 39.6548C35.3345 38.1165 35.9085 36.6535 36.6656 35.3058L33.6628 33.6175C32.7487 35.2449 32.0576 37.008 31.6174 38.8569L34.968 39.6548ZM36.6656 35.3058C37.5331 33.7613 38.6399 32.3697 39.9485 31.1905L37.6433 28.63C36.0511 30.0648 34.7104 31.7527 33.6628 33.6175L36.6656 35.3058Z" fill="black"/>
<path d="M41.5947 21.2909L39.7526 21.9052C37.7545 22.5716 35.5547 22.1791 33.9099 20.8625C32.0186 19.3486 29.4199 19.0732 27.2535 20.157L25.5862 20.9912" stroke="black" stroke-width="5" stroke-linecap="square"/>
</svg>
`;
    const svgBar = `
<svg width="18.5" height="23" viewBox="0 0 37 46" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.4603 6.7238C5.11503 5.55594 6.31206 4.80999 7.64646 4.80999C8.99979 4.80999 10.237 5.57322 10.882 6.7238H14.2549C14.8999 5.57325 16.1372 4.80999 17.4905 4.80999C18.8626 4.80999 20.1399 5.58996 20.7754 6.7238H24.1484C24.803 5.55594 26.0001 4.80999 27.3346 4.80999C29.3177 4.80999 31.026 6.48579 31.026 8.6793C31.026 10.8728 29.3177 12.5486 27.3346 12.5486C26.0001 12.5486 24.803 11.8027 24.1484 10.6348H20.7754C20.1399 11.7686 18.8626 12.5486 17.4905 12.5486C16.1372 12.5486 14.8999 11.7854 14.2549 10.6348H10.882C10.237 11.7854 8.99979 12.5486 7.64646 12.5486C6.31206 12.5486 5.11503 11.8027 4.4603 10.6348C4.14071 10.0648 3.95495 9.39881 3.95495 8.6793C3.95495 7.95979 4.14071 7.29383 4.4603 6.7238ZM7.64646 0.940674C4.81666 0.940674 2.37786 2.52908 1.0874 4.83083C0.449729 5.96818 0.0876465 7.28452 0.0876465 8.6793C0.0876465 10.0741 0.449729 11.3904 1.0874 12.5278C1.76399 13.7346 2.75621 14.7453 3.95495 15.4338V42.5275L7.05758 45.4378H27.9234L31.026 42.5275V37.6992C34.2297 37.6992 36.827 35.1005 36.827 31.8952V24.1566C36.827 20.9512 34.2297 18.3526 31.026 18.3526V15.4363C33.3485 14.1026 34.8933 11.5525 34.8933 8.6793C34.8933 4.46193 31.5649 0.940674 27.3346 0.940674C25.4615 0.940674 23.7599 1.63648 22.4491 2.77437C21.0984 1.62761 19.3465 0.940674 17.4905 0.940674C15.6259 0.940674 13.8993 1.63202 12.5685 2.77442C11.2377 1.63202 9.51104 0.940674 7.64646 0.940674ZM27.1587 16.4159C25.3553 16.3738 23.7189 15.6864 22.4491 14.5842C21.0984 15.731 19.3465 16.4179 17.4905 16.4179C15.6259 16.4179 13.8993 15.7266 12.5685 14.5842C11.2796 15.6906 9.61943 16.3739 7.82224 16.4159V40.8514L8.58691 41.5685H26.394L27.1587 40.8514V16.4159ZM32.9597 24.1566V31.8952C32.9597 32.9636 32.0939 33.8298 31.026 33.8298V22.2219C32.0939 22.2219 32.9597 23.0881 32.9597 24.1566ZM11.6895 35.7645V20.2872H15.5568V35.7645H11.6895ZM19.4241 20.2872V35.7645H23.2914V20.2872H19.4241Z" fill="black"/>
</svg>
`;
    const svgVest = `
<svg width="19" height="22" viewBox="0 0 38 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M26.943 4.76012C26.0366 8.28327 22.84 10.8865 19.0359 10.8865C15.2317 10.8865 12.0351 8.28327 11.1288 4.76012H8.8305V7.17356C8.8305 10.1356 7.17968 12.7119 4.74835 14.0317V39.4765H33.3234V14.0317C30.8921 12.7119 29.2412 10.1356 29.2412 7.17356V4.76012H26.943ZM6.44924 0.675842C5.50987 0.675842 4.74835 1.43776 4.74835 2.37762V7.17356C4.74835 9.22417 3.08685 10.8865 1.03731 10.8865C0.832342 10.8865 0.666199 11.0528 0.666199 11.2578V39.4765C0.666199 41.7322 2.49384 43.5607 4.74835 43.5607H33.3234C35.578 43.5607 37.4055 41.7322 37.4055 39.4765V11.2578C37.4055 11.0528 37.2394 10.8865 37.0345 10.8865C34.9848 10.8865 33.3234 9.22417 33.3234 7.17356V2.37762C33.3234 1.43776 32.5619 0.675842 31.6226 0.675842H24.1386C23.575 0.675842 23.118 1.133 23.118 1.69691V2.71798C23.118 4.97366 21.2904 6.80226 19.0359 6.80226C16.7813 6.80226 14.9537 4.97366 14.9537 2.71798V1.69691C14.9537 1.133 14.4968 0.675842 13.9332 0.675842H6.44924Z" fill="black"/>
</svg>
`;
    const svgTv = `
<svg width="26" height="22" viewBox="0 0 52 43" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M46.7996 0.881363H4.71632C2.14457 0.881363 0.0404053 2.98662 0.0404053 5.55971V33.6298C0.0404053 36.2029 2.14457 38.3082 4.71632 38.3082H16.4061V42.9865H35.1098V38.3082H46.7996C49.3713 38.3082 51.4521 36.2029 51.4521 33.6298L51.4755 5.55971C51.4755 2.98662 49.3713 0.881363 46.7996 0.881363ZM46.7996 33.6298H4.71632V5.55971H46.7996V33.6298Z" fill="black"/>
</svg>
`;
    const svgChuuras = `
<svg width="23" height="22" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M43.2195 6.44273C42.9245 5.85155 42.4861 5.28113 41.5708 5.41803C40.8274 5.52916 40.1627 5.73619 38.9939 5.01897C35.546 2.09452 29.3859 0.146179 22.3577 0.146179C15.3266 0.146179 9.16424 2.09598 5.71787 5.02181C4.55188 5.7355 3.88791 5.52916 3.146 5.41803C2.23068 5.28122 1.79239 5.85155 1.49721 6.44273C1.08751 7.26324 -0.580568 10.1725 0.947156 11.3958C2.13251 12.3453 2.71124 12.94 2.99557 13.2912C4.21606 21.6408 11.1403 30.2314 22.3577 30.2314C33.5765 30.2314 40.5008 21.6409 41.7211 13.2912C42.0055 12.94 42.5842 12.3453 43.7696 11.3958C45.2973 10.1725 43.6292 7.26324 43.2195 6.44273ZM6.472 10.4169C6.472 7.27462 10.1226 4.56451 15.4289 3.26249L6.68538 11.6624C6.55656 11.2553 6.472 10.8419 6.472 10.4169ZM8.03055 13.8557C7.9683 13.7913 7.91387 13.7232 7.85437 13.6572L19.3553 2.61109C19.5015 2.59679 19.6411 2.57379 19.7893 2.56164C20.6674 2.48212 21.5662 2.4449 22.4801 2.4449C23.066 2.4449 23.6396 2.46851 24.209 2.50297L10.4671 15.6889C9.49309 15.137 8.66654 14.5265 8.03055 13.8557ZM16.4546 17.8085C15.1139 17.5405 13.8662 17.1779 12.7353 16.7493C12.7088 16.7393 12.6852 16.7278 12.6594 16.7171L27.1599 2.78813C27.1921 2.79244 27.2259 2.79528 27.2574 2.80028C28.6417 3.01816 29.9395 3.33064 31.1364 3.71462C31.1506 3.71893 31.1643 3.7247 31.1785 3.7297L16.5041 17.8171C16.4883 17.8142 16.4711 17.812 16.4546 17.8085ZM24.0959 18.3524C23.5674 18.3818 23.0237 18.3961 22.4802 18.3961C21.3952 18.3961 20.3329 18.3402 19.3074 18.2341L33.4726 4.63335C34.6342 5.17292 35.6349 5.80563 36.4284 6.5151C36.4899 6.56817 36.5451 6.62408 36.6046 6.67853L24.4748 18.323C24.3473 18.3301 24.2241 18.3467 24.0959 18.3524ZM28.2134 17.8586L37.9933 8.4699C38.3106 9.09407 38.4868 9.74685 38.4868 10.4169C38.4868 13.82 34.2246 16.7128 28.2134 17.8586Z" fill="black"/>
<path d="M32.8423 28.5645C31.7135 29.2546 30.4894 29.8342 29.176 30.2842L30.675 34.0363H14.0409L15.5793 30.1839C14.2328 29.8456 12.9738 29.3684 11.7998 28.783L7.99897 40.0471C7.65298 40.9901 8.08128 42.0177 8.95726 42.3401C9.83392 42.6633 10.8251 42.1587 11.1725 41.2165L12.8807 36.9406H31.8352L33.5434 41.2165C33.8909 42.1587 34.8821 42.6632 35.7586 42.3401C36.6346 42.0177 37.0629 40.9901 36.717 40.0471L32.8423 28.5645Z" fill="black"/>
</svg>
`;
    const svgFestas = `
<svg id="fest" width="21" height="21" viewBox="0 0 41 42" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6.57626 26.5715L15.2615 35.3055M36.5228 2.27076C32.9654 2.23796 31.3182 3.88314 30.7781 5.54577C30.3024 7.00983 30.737 10.0084 29.6015 12.2295C28.5156 14.3532 25.6417 15.5521 22.3784 15.6531M38.7538 11.1979L38.7761 11.1981M36.5237 29.8294L36.546 29.8296M9.76244 3.02835L9.78474 3.02857M36.5237 19.0056C33.1786 19.0056 30.9485 20.1213 28.93 22.2084M16.9828 10.2553C18.6829 7.84967 19.7979 5.61825 18.7011 2.08687M2.0368 39.8808L9.92142 16.213L25.6908 31.9916L2.0368 39.8808Z" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
`;

const recursoInfo = {
        'bar': { svg: svgBar, nome: 'Bar' },
        'bebedouro': { svg: svgBebedouro, nome: 'Bebedouro' },
        'vestiario': { svg: svgVest, nome: 'Vestiário' },
        'tv': { svg: svgTv, nome: 'TV' },
        'churrasqueira': { svg: svgChuuras, nome: 'Churrasqueira' },
        'festas': { svg: svgFestas, nome: 'Área de Festas' }
    };

    // Gerar os ícones e nomes legíveis baseados nos recursos disponíveis
    const recursosLegíveis = recursos.map(recurso => {
        if (recursoInfo.hasOwnProperty(recurso)) {
            icones.push(recursoInfo[recurso].svg);
            return recursoInfo[recurso].nome;
        }
        return recurso; // caso o recurso não esteja mapeado
    });

    // Exibir os ícones na página
    if (icones.length > 0) {
        document.getElementById("recursos").innerHTML = icones.join(' ');
    } else {
        document.getElementById("recursos").innerHTML = "Nenhum recurso disponível";
    }

    // Exibir a lista de recursos em texto
    if (recursosLegíveis.length > 0) {
        document.getElementById("recursos-texto").innerHTML = recursosLegíveis.join(', ');
    } else {
        document.getElementById("recursos-texto").innerHTML = "Nenhum recurso disponível";
    }
    </script>

      <div>
        <div id="grid-reserva">
          <div id="dono-container">
            <img src="../<?php echo htmlspecialchars($quadra['imagem_proprietario']); ?>"
              alt="Imagem de perfil de <?php echo htmlspecialchars($quadra['nome_proprietario']); ?>"
              class="imagem-perfil">
            <a href="perfil_dono.php?id=<?php echo htmlspecialchars($quadra['proprietario_id']); ?>"
              id="client-container">
              <div>
                <h4>Anfitriã(o): <?php echo htmlspecialchars($quadra['nome_proprietario']); ?></h4>
                <h5>Entrou em </h5>
              </div>
            </a>
          </div>

          <form action="../../controllers/ClientController.php?action=reservarQuadra" method="POST">
            <div class="container-reserva">
              <h2>Verificar horário</h2>
              <div class="date-time">
                <input type="date" id="data_reserva" name="data_reserva" min="<?= date('Y-m-d') ?>">
                <select id="horario_inicio" name="horario_inicio">
                  <option value="">Início</option>
                </select>
                <select id="horario_fim" name="horario_fim">
                  <option value="">Fim</option>
                </select>
              </div>
              <button class="reserve-button" id="btn_reservar" type="submit">Reservar</button>
              <div class="price-info">
                <span>Duração: <span id="duracao">0</span> hora(s)</span>
                <span>R$<span id="preco_hora"><?= htmlspecialchars($quadra['valor']) ?></span>/hora</span>
              </div>
              <div class="total">
                <span>Total a pagar</span>
                <span>R$<span id="total_pagar">0</span></span>
              </div>
              <input type="hidden" name="id_quadra" value="<?= $id_quadra ?>">
            </div>
          </form>
        </div>
        <script>
document.addEventListener('DOMContentLoaded', function () {
  const dataReserva = document.getElementById('data_reserva');
  const horarioInicio = document.getElementById('horario_inicio');
  const horarioFim = document.getElementById('horario_fim');
  const btnReservar = document.getElementById('btn_reservar');
  const duracaoSpan = document.getElementById('duracao');
  const totalPagarSpan = document.getElementById('total_pagar');
  const precoHora = parseFloat(document.getElementById('preco_hora').textContent);

  let horarioIntervaloInicio = null;
  let horarioIntervaloFim = null;
  const fimDoExpediente = '22:00'; // Ajuste conforme necessário

  dataReserva.addEventListener('change', function () {
    const dataSelecionada = this.value;

    fetch(`../../controllers/AuthController.php?action=getHorariosDisponiveis&quadra_id=<?= $id_quadra ?>&data=${dataSelecionada}`)
      .then(response => response.json())
      .then(data => {
        if (data.length === 0) {
          alert('Nenhum horário disponível para essa data.');
          return;
        }
        identificarIntervalo(data);
        preencherHorarios(data);
      })
      .catch(error => console.error('Erro ao buscar horários:', error));
  });

  function identificarIntervalo(data) {
    horarioIntervaloInicio = null;
    horarioIntervaloFim = null;
    data.forEach(periodo => {
      if (periodo.tipo === 'intervalo') {
        horarioIntervaloInicio = periodo.horario_inicio;
        horarioIntervaloFim = periodo.horario_fim;
      }
    });
    console.log("Intervalo identificado:", horarioIntervaloInicio, horarioIntervaloFim);
  }

  function preencherHorarios(data) {
    horarioInicio.innerHTML = '<option value="">Início</option>';
    horarioFim.innerHTML = '<option value="">Fim</option>';

    data.forEach(periodo => {
      if (periodo.tipo === 'disponível') {
        let inicio = new Date(`2000-01-01T${periodo.horario_inicio}`);
        let fim = new Date(`2000-01-01T${periodo.horario_fim}`);

        while (inicio < fim) {
          let horaFormatada = inicio.toTimeString().slice(0, 5);
          let optionInicio = document.createElement('option');
          optionInicio.value = horaFormatada;
          optionInicio.textContent = horaFormatada;
          horarioInicio.appendChild(optionInicio);

          inicio.setMinutes(inicio.getMinutes() + 30);
        }
      }
    });

    btnReservar.disabled = true;
  }

  horarioInicio.addEventListener('change', function () {
    horarioFim.innerHTML = '<option value="">Fim</option>';

    if (this.value) {
      let inicioSelecionado = new Date(`2000-01-01T${this.value}`);
      let limiteFim = new Date(`2000-01-01T${fimDoExpediente}`);

      // Se há um intervalo e o início selecionado é antes do intervalo,
      // o limite de fim é o início do intervalo
      if (horarioIntervaloInicio && inicioSelecionado < new Date(`2000-01-01T${horarioIntervaloInicio}`)) {
        limiteFim = new Date(`2000-01-01T${horarioIntervaloInicio}`);
      }

      let atual = new Date(inicioSelecionado.getTime() + 30 * 60000); // 30 minutos após o início

      while (atual <= limiteFim) {
        let horaFormatada = atual.toTimeString().slice(0, 5);
        let optionFim = document.createElement('option');
        optionFim.value = horaFormatada;
        optionFim.textContent = horaFormatada;
        horarioFim.appendChild(optionFim);

        atual.setMinutes(atual.getMinutes() + 30);
      }
    }

    atualizarCalculo();
  });

  horarioFim.addEventListener('change', atualizarCalculo);

  function atualizarCalculo() {
    if (horarioInicio.value && horarioFim.value) {
      const duracao = calcularDuracao(horarioInicio.value, horarioFim.value);
      duracaoSpan.textContent = duracao.toFixed(2);
      totalPagarSpan.textContent = (duracao * precoHora).toFixed(2);
      btnReservar.disabled = false;
    } else {
      duracaoSpan.textContent = '0';
      totalPagarSpan.textContent = '0';
      btnReservar.disabled = true;
    }
  }

  function calcularDuracao(inicio, fim) {
    const [horaInicio, minInicio] = inicio.split(':').map(Number);
    const [horaFim, minFim] = fim.split(':').map(Number);
    return ((horaFim * 60 + minFim) - (horaInicio * 60 + minInicio)) / 60;
  }

  btnReservar.addEventListener('click', function (event) {
    if (!dataReserva.value || !horarioInicio.value || !horarioFim.value) {
      alert('Por favor, selecione uma data e horários válidos.');
      event.preventDefault();
    }
  });
});
        </script>
</body>

</html>