<!--Script import for functionalities-->
<script>

    //Tables Scripts
    document.addEventListener('DOMContentLoaded', function () {
        
        const tableOptions = {
            perPage: 5
        };

        const rTable = document.querySelector("#reservationTable");
        if (rTable) new simpleDatatables.DataTable(rTable, tableOptions);

        const dTable = document.querySelector("#distributionTable");
        if (dTable) new simpleDatatables.DataTable(dTable, tableOptions);

        const iTable = document.querySelector("#inventoryTable");
        if (iTable) new simpleDatatables.DataTable(iTable, tableOptions);

        const sTable = document.querySelector("#stocksTable");
        if (sTable) new simpleDatatables.DataTable(sTable, tableOptions);

        //Modal Functions Scripts
        //update & Delete
        const showUpdate = document.getElementById('showUpdateModal');
        const updateModal = document.getElementById('updateModal');
        const showDelete = document.getElementById('showDeleteModal');
        const deleteModal = document.getElementById('deleteModal');

        //Entry Modals
        const showEntry = document.getElementById('showDistribution');
        const distributionModal = document.getElementById('distributionEntry');
        const showInventory = document.getElementById('showInventory');
        const inventoryModal = document.getElementById('inventoryEntry');
        const showReservation = document.getElementById('showReservation');
        const reservationModal = document.getElementById('reservationModal');

        //update & Delete Functions
        if (showUpdate && updateModal) {
            showUpdate.addEventListener('click', ()=> {
                updateModal.showModal();
            });
        }

        if (showDelete && deleteModal) {
            showDelete.addEventListener('click', ()=> {
                deleteModal.showModal();
            });
        }

        //Entry Modals Functions
        if (showEntry && distributionModal) {
            showEntry.addEventListener('click', () => {
                distributionModal.showModal();
            });
        }

        if (showInventory && inventoryModal) {
            showInventory.addEventListener('click', () => {
                inventoryModal.showModal();
            });
        }

        if (showReservation && reservationModal) {
            showReservation.addEventListener('click', () => {
                reservationModal.showModal();
            });
        }

    });

    //Message Timer
    setTimeout(function() {
    const header = document.getElementById('inventoryMessage');
        if (header) {
            header.style.transition = "opacity 0.5s ease";
            header.style.opacity = 0;

            // Optionally remove from layout after fade out
            setTimeout(() => {
                header.style.display = "none";
            }, 500);
        }
    }, 3000); // 3000ms = 3 seconds



</script>