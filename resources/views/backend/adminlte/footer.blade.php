  <footer class="app-footer">
    <div class="float-end d-none d-sm-inline small text-secondary">Espace agents des CEFORE</div>
    <strong>&copy; {{ date('Y') }} <a href="https://me.bf" class="text-decoration-none">Maison de l’Entreprise du Burkina Faso</a></strong>
  </footer>
</div>

{{-- Bibliothèques servies depuis public/vendor (versions listées dans public/vendor/VERSIONS.md) --}}
<script src="{{ asset('vendor/bootstrap-5.3.8/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte-4.10.0/adminlte.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/jszip-3.10.2/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake-0.2.23/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake-0.2.23/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-2.3.8/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('backend/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
{{-- Gestionnaires data-csp-* (remplacent les onclick/onchange interdits par la CSP) --}}
<script src="{{ asset_version('js/csp-handlers.js') }}"></script>
{{-- Messages lisibles pour les erreurs des appels AJAX --}}
<script src="{{ asset_version('js/erreurs-ajax.js') }}"></script>
{{-- Tableaux, calendriers et messages de l'espace agents --}}
<script src="{{ asset_version('js/espace-agents.js') }}"></script>
{{-- Rechargement de la page après inactivité (le serveur déconnecte alors l'agent) --}}
<script src="{{ asset_version('js/inactivite.js') }}"></script>
</body>
</html>
