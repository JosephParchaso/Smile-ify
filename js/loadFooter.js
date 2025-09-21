document.addEventListener("DOMContentLoaded", () => {
    fetch(`${BASE_URL}/processes/get_services.php`)
        .then(res => res.json())
        .then(services => {
            const container = document.getElementById("footerServices");
            container.innerHTML = "";
            services.forEach(service => {
                const p = document.createElement("p");
                p.className = "footerDes";
                p.textContent = service.name;
                container.appendChild(p);
            });
        });

    fetch(`${BASE_URL}/processes/get_branches.php`)
        .then(res => res.json())
        .then(branches => {
            const container = document.getElementById("footerBranches");
            container.innerHTML = "";
            branches.forEach(branch => {
                const a = document.createElement("a");
                a.href = branch.map_url;
                a.textContent = branch.name;
                a.className = "footerDes";
                a.target = "_blank";
                container.appendChild(a);
                container.appendChild(document.createElement("br"));
            });
        });
});
