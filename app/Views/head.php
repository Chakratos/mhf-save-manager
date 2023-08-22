<link rel="stylesheet" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/css/datatables.min.css"/>
<link rel="stylesheet" href="/css/select2.min.css"/>
<link rel="stylesheet" href="/css/select2-bootstrap4.min.css"/>
<link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="/css/tempusdominus-bootstrap-4.min.css"/>
<link rel="stylesheet" href="/css/fontawesome.min.css"/>
<link rel="stylesheet" href="/css/solid.css"/>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/popper.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/datatables.min.js"></script>
<script type="text/javascript" src="/js/select2.min.js"></script>
<script type="text/javascript" src="/js/moment.min.js"></script>
<script type="text/javascript" src="/js/tempusdominus-bootstrap-4.min.js"></script>
<?php
$UILocale = \MHFSaveManager\Service\UIService::getForLocale();
$darkmode = false;
if ($darkmode) {
    echo <<<HTML
<link rel="stylesheet" href="/css/bootstrap-nightfall.min.css">
<style>
    @media (prefers-color-scheme: dark) {
        img:not([src*=".svg"]) {
            opacity: .75;
            transition: opacity .5s ease-in-out;
            &:hover {
                 opacity: 1;
             }
        }
    }
</style>
HTML;
}
?>

