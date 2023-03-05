<?php

function findShortestPath($maze, $start, $end) {
    $rows = count($maze);
    $cols = count($maze[0]);
    
    $queue = array($start);
    $visited = array($start);
    $distances = array($start => 0);
    $parents = array($start => null);
    
    while (!empty($queue)) {
        $current = array_shift($queue);
        if ($current[0] == $end[0] && $current[1] == $end[1]) {
            $path = array();
            while ($current != $start) {
                array_unshift($path, $current);
                $current = $parents[$current];
            }
            array_unshift($path, $start);
            return array('path' => $path, 'distance' => $distances[$end]);
        }
        $neighbors = array(
            array($current[0] - 1, $current[1]),
            array($current[0] + 1, $current[1]),
            array($current[0], $current[1] - 1),
            array($current[0], $current[1] + 1)
        );
        foreach ($neighbors as $neighbor) {
            if ($neighbor[0] >= 0 && $neighbor[0] < $rows && $neighbor[1] >= 0 && $neighbor[1] < $cols && $maze[$neighbor[0]][$neighbor[1]] != 0 && !in_array($neighbor, $visited)) {
                $queue[] = $neighbor;
                $visited[] = $neighbor;
                $distances[$neighbor] = $distances[$current] + $maze[$neighbor[0]][$neighbor[1]];
                $parents[$neighbor] = $current;
            }
        }
    }
    
    return null;
}

// Пример использования
$maze = array(
    array(1, 0, 1, 1),
    array(1, 1, 1, 0),
    array(1, 0, 1, 1),
    array(1, 1, 1, 1)
);
$start = array(0, 0);
$end = array(3, 3);
$result = findShortestPath($maze, $start, $end);
if ($result) {
    echo "Кратчайший путь: ";
    foreach ($result['path'] as $point) {
        echo "(" . $point[0] . ", " . $point[1] . ") ";
    }
    echo "<br>Длина пути: " . $result['distance'];
} else {
    echo "Путь не найден";
}
?>
