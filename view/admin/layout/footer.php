</div>
</div>
<script>
    let menuicn = document.querySelector(".menuicn");
    let nav = document.querySelector(".navcontainer");

    menuicn.addEventListener("click", () => {
        nav.classList.toggle("navclose");
    })


    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const isConfirmed = confirm('¿Estás seguro de que deseas eliminar este registro?');
                if (!isConfirmed) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
</body>

</html>