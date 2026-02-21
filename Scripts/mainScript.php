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

        const oTable = document.querySelector("#organizationTable");
        if (oTable) new simpleDatatables.DataTable(oTable, tableOptions);

        const moTable = document.querySelector("#myorganizationTable");
        if (moTable) new simpleDatatables.DataTable(moTable, tableOptions);

        // User Role from PHP Session
        const userRole = "<?= $_SESSION['ROLE']; ?>"; // PHP → JS

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

        // Organization Modals
        const showCreateOrganization = document.getElementById('showCreateOrganization');
        const createOrganizationModal = document.getElementById('organizationCreationEntry');
        const showLeaveOrganization = document.getElementById('showLeaveOrganization');
        const leaveOrganizationModal = document.getElementById('organizationLeave');

        // Oragnization Tables
        const showOrganizationcon = document.getElementById('showorganizationTable');
        const OrganizationTablecon = document.getElementById('organizationTablecon');
        const showMyOrganizationCon = document.getElementById('showmyorganizationTable');
        const myOrganizationTableConOWNER = document.getElementById('myorganizationTableconOWNER');
        const myOrganizationTableConMEMBER = document.getElementById('myorganizationTableconMEMBER');

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

        // Organization Modals Functions
        if (showCreateOrganization && createOrganizationModal) {
            showCreateOrganization.addEventListener('click', () => {
                createOrganizationModal.showModal();
            });
        }

        if (showLeaveOrganization && leaveOrganizationModal) {
            showLeaveOrganization.addEventListener('click', () => {
                leaveOrganizationModal.showModal();
            });
        }

        // Organization Tables Functions
        if (showOrganizationcon && myOrganizationTableConMEMBER && myOrganizationTableConOWNER && OrganizationTablecon) {
            showOrganizationcon.addEventListener('click', () => {

                // show organization table, hide my organization
                OrganizationTablecon.classList.remove('hidden');
                myOrganizationTableConMEMBER.classList.add('hidden');
                myOrganizationTableConOWNER.classList.add('hidden');


                // visual active state on buttons
                showOrganizationcon.classList.add('text-white');
                showMyOrganizationCon.classList.remove('text-white');
            });
        }

        if (showMyOrganizationCon && myOrganizationTableConMEMBER && myOrganizationTableConOWNER && OrganizationTablecon) {
            showMyOrganizationCon.addEventListener('click', () => {

                // show my organization, hide organization
                // Check Role to show appropriate my organization table
                if (userRole === 'MEMBER') {
                    myOrganizationTableConMEMBER.classList.remove('hidden');
                    myOrganizationTableConOWNER.classList.add('hidden'); // hide OWNER table
                } else {
                    myOrganizationTableConOWNER.classList.remove('hidden');
                    myOrganizationTableConMEMBER.classList.add('hidden'); // hide MEMBER table
                }

                OrganizationTablecon.classList.add('hidden');

                // visual active state on buttons
                showMyOrganizationCon.classList.add('text-white');
                showOrganizationcon.classList.remove('text-white');
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