@if (env('GOOGLE_ANALYTIC'))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTIC') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', '{{ env('GOOGLE_ANALYTIC') }}');
</script>
@endif