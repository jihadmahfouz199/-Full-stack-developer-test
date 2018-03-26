<?php
/**
 * Created by PhpStorm.
 * User: Mahfouz
 * Date: 3/25/2018
 * Time: 8:54 PM
 */

class Item_model extends CI_Model
{

    public function get_items()
    {
        $items = array();
        $this->db->select("*");
        $this->db->from("items");
        $query = $this->db->get();
        $result = $query->result();
        foreach ($result as $r) {
            $r->tags = $this->getItemTags($r->id);
            array_push($items, $r);
        }
        return $items;
    }

    public function getItemTags($item)
    {
        $this->db->select("tags.*");
        $this->db->from('item_tags');
        $this->db->join('tags', 'item_tags.tag = tags.id');
        $this->db->where('item_tags.item', $item);

        $query = $this->db->get();
        return $query->result();
    }

    public function getTags()
    {
        $this->db->select("*");
        $this->db->from('tags');
        $query = $this->db->get();
        return $query->result();
    }

    public function itemAdd($data)
    {
        $data = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'picture' => $data['picture']
        );

        $this->db->insert('items', $data);
    }
}
