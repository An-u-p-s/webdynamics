<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

                 <style>
                        /* CSS3 */

/* The whole thing */
#project-menu {
    /* display: none; */
    z-index: 1000;
    position: absolute;
    overflow: hidden;
    border: 1px solid #CCC;
    white-space: nowrap;
    font-family: sans-serif;
    background: #FFF;
    color: #333;
    border-radius: 5px;
    padding: 0;
}

/* Each of the items in the list */
#project-menu li {
    padding: 8px 12px;
    cursor: pointer;
    list-style-type: none;
    transition: all .3s ease;
}

#project-menu li:hover {
    background-color: #DEF;
}
</style>
<!-- Dynamic Right-Click Menu -->
<div id="rightclick"></div>

