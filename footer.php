 <!-- Footer -->
 <?php if($authenticator->isAuthenticated() ): ?>
        <footer class="text-center">
            <ul class="nav navbar-nav">
                <li>
                    <a id="footer-links" href="admin.php?action=challenges">Challenges</a>
                </li>
                <li>
                    <a id="footer-links" href="admin.php?action=about">About</a>
                </li>
                <li>
                    <a id="footer-links" href="admin.php?action=profile">Profile</a>
                </li>
                <li>
                    <a id="footer-links" href="admin.php?action=sitemap">Sitemap</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Pungent 2015</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->
<?php endif; ?>
    <!-- jQuery -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script data-main="js/popups.js" src="js/require.js"></script>
    <!-- Prefixfree -->
    <script src="js/prefixfree.min.js" type="text/javascript"></script>
    <!-- DoubleTapToGo  -->
    <script src="js/doubletaptogo.js"></script>
    <!-- jQuery Popup Overlay -->
    <script src="js/jquery.popupoverlay.js"></script>
    <script src="js/popups.js"></script>
</body>

</html>
