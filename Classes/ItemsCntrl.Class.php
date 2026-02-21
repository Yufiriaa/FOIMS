<?php
include_once __DIR__ . '/Items.Class.php';

class ItemsCntrl extends Items {

    private $name;
    private $quantity;
    private $price;
    private $description;
    private $id;

    public function __construct($id = "", $name = "", $quantity = "", $price = "", $description = "") {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->description = $description;
        
    }

    // Add Item
    public function addItem() {

        return $this->insertItem(
            $this->id,
            $this->name,
            $this->quantity,
            $this->price,
            $this->description,
        );
    }

    // Add Reservation
    public function addReservation($materialID, $userID, $quantity, $requestor, $claimDate, $remarks) {

        // Implementation for adding reservation
        return $this->insertReservation(
            $materialID,
            $userID,
            $quantity,
            $requestor,
            $claimDate,
            $remarks
        );
    }

    // Update Item
    public function updateItem() {

        return $this->updateItemDB(
            $this->name,
            $this->quantity,
            $this->price,
            $this->description,
            $this->id
        );
    }

    // Update Reservation Status
    public function updateReservationStatus($reservationID, $status) {

        return $this->updateReservationStatusDB(
            $reservationID,
            $status
        );
    }

    // Delete Item
    public function deleteItem() {

        return $this->deleteItemDB(
            $this->id
        );

    }

    // Delete Reservation
    public function deleteReservation($ID) {

        return $this->deleteReservationDB(
            $ID
        );

    }
}
